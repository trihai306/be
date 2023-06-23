import re
import nltk
import numpy as np
import requests
from sklearn.feature_extraction.text import TfidfVectorizer, CountVectorizer
from typing import List, Dict, Tuple
import price_parser
from underthesea import word_tokenize

nltk.download('punkt')


class PostAnalyzer:
    # Phương thức khởi tạo, nhận vào danh sách các bài đăng và từ khóa sản phẩm
    def __init__(self, posts: List[Tuple[str, str]], product_keywords: List[str]):
        self.posts = posts
        self.product_keywords = product_keywords
        with open("vietnamese_stopwords.txt", "r", encoding="utf-8") as f:
            self.stop_words = f.read().splitlines()
        self.keyword_lists = self.extract_keywords()  # tạo danh sách từ khóa cho mỗi bài đăng

    def remove_stopwords(self, text):
        tokens = word_tokenize(text, format='text').split()
        tokens = [word for word in tokens if word not in self.stop_words]
        return ' '.join(tokens)

    # Cập nhật từ khóa sản phẩm bằng cách sử dụng CountVectorizer để tìm các từ phổ biến

    def update_product_keywords(self, n_keywords=10):
        vectorizer = CountVectorizer(tokenizer=word_tokenize)
        X = vectorizer.fit_transform([self.remove_stopwords(post_content) for _, post_content in self.posts])
        frequencies = np.sum(X.toarray(), axis=0)
        frequencies_idx = frequencies.argsort()[-n_keywords:]
        self.product_keywords = np.array(vectorizer.get_feature_names_out())[frequencies_idx].tolist()
        print(f"Updated product keywords: {self.product_keywords}")

    # Trích xuất từ khóa từ mỗi bài đăng bằng cách sử dụng TF-IDF

    def extract_keywords(self, top_n: int = 10) -> List[List[str]]:
        vectorizer = TfidfVectorizer(tokenizer=word_tokenize, ngram_range=(1, 3))
        tfidf_matrix = vectorizer.fit_transform([self.remove_stopwords(post_content) for _, post_content in self.posts])
        feature_names = vectorizer.get_feature_names_out()
        keyword_lists = []

        for i in range(len(self.posts)):
            row = tfidf_matrix.getrow(i).toarray()[0].ravel()
            top_indices = row.argsort()[-top_n:]
            keywords = [feature_names[ind] for ind in top_indices]
            keyword_lists.append(keywords)

        return keyword_lists

    # Phân tích một bài đăng cụ thể, tìm kiếm các từ khóa, từ viết tắt, số điện thoại, từ lặp lại, và giá
    def analyze_post(self, post: str, keywords: List[str]) -> Dict[str, List[str]]:
        abbreviations = ["LH", "SĐT", "FB", "Zalo", "Viber", "Ship", "COD", 'IB', "INBOX"]
        phone_number_pattern = r"\b(0\d{2,3}[-.\s]?\d{3,4}[-.\s]?\d{3,4})\b"
        found_keywords = [keyword for keyword in keywords if keyword in post.lower()]
        found_abbreviations = [abbreviation for abbreviation in abbreviations if abbreviation.lower() in post.lower()]
        found_phone_numbers = re.findall(phone_number_pattern, post)
        repeated_words = self.detect_repeated_words(post)
        price_info = self.extract_price(post)
        email_pattern = r'\b[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Z|a-z]{2,}\b'
        social_media_keywords = ['www.', 'http://', 'https://', 'fb.com/', 'instagram.com/', 'twitter.com/']
        found_emails = re.findall(email_pattern, post)
        found_social_media_links = [word for word in post.split() if
                                    any(keyword in word for keyword in social_media_keywords)]
        return {
            "keywords": found_keywords,
            "abbreviations": found_abbreviations,
            "phone_numbers": found_phone_numbers,
            "emails": found_emails,
            "social_media_links": found_social_media_links,
            "repeated_words": repeated_words,
            "price_info": price_info
        }

    # Trích xuất thông tin giá từ một bài đăng
    def extract_price(self, post: str) -> str:
        price = price_parser.parse_price(post)
        return str(price)

    # Tìm kiếm các từ lặp lại trong một bài đăng
    def detect_repeated_words(self, post: str) -> List[str]:
        words = post.lower().split()
        repeated_words = [word for word in words if words.count(word) > 1]
        return list(set(repeated_words))

    # Phân loại một bài đăng là bài đăng mua hàng, bán hàng, hoặc không xác định
    def classify_post(self, post: str, keywords: List[str]) -> Tuple[str, Dict[str, List[str]]]:
        seller_keywords = ['bán', 'giá', 'mua', 'sản phẩm', 'giao hàng', 'kho hàng', 'cung cấp', 'dịch vụ', 'mới',
                           'giảm giá']
        buyer_keywords = ['cần mua', 'tìm', 'ai có', 'báo giá giúp', 'hỏi', 'muốn mua', 'tìm kiếm', 'cần tìm',
                          'tìm sản phẩm']
        seller_score = sum([post.lower().count(keyword) for keyword in seller_keywords])
        buyer_score = sum([post.lower().count(keyword) for keyword in buyer_keywords])

        interested_products = []

        if seller_score > buyer_score:
            user_type = 'Bài viết bán hàng'
        elif buyer_score > seller_score:
            user_type = 'Bài viết mua hàng'
            interested_products = [product for product in self.product_keywords if product in post.lower()]
        else:
            user_type = 'Bài viết không xác định'

        analysis_result = self.analyze_post(post, keywords)
        analysis_result['interested_products'] = interested_products

        return user_type, analysis_result

    # Phân tích tất cả các bài đăng và in ra kết quả
    def analyze_posts(self):
        for (post_id, post_content), keywords in zip(self.posts, self.keyword_lists):
            print("-------")
            print("ID bài đăng:", post_id)
            user_type, analysis_result = self.classify_post(post_content, keywords)
            print("Loại bài viết:", user_type)

            for key, values in analysis_result.items():
                if values:
                    print(f"Tìm thấy {key}: {', '.join(values)}")

    # Phân loại người dùng dựa trên số lượng các loại bài đăng mà họ đã đăng
    def classify_user(self):
        seller_posts = 0
        buyer_posts = 0
        unknown_posts = 0

        for (post_id, post_content), keywords in zip(self.posts, self.keyword_lists):
            user_type, _ = self.classify_post(post_content, keywords)

            if user_type == 'Bài viết bán hàng':
                seller_posts += 1
            elif user_type == 'Bài viết mua hàng':
                buyer_posts += 1
            else:
                unknown_posts += 1

        if seller_posts > buyer_posts and seller_posts > unknown_posts:
            return "Người bán hàng"
        elif buyer_posts > seller_posts and buyer_posts > unknown_posts:
            return "Người mua hàng"
        else:
            return "Người dùng Facebook bình thường"


def get_facebook_posts():
    url = "https://graph.facebook.com/1575795309135150/feed"
    params = {
        "access_token": "EAAGNO4a7r2wBABEasuxfwoM6qGpGZCCtquZBjYgxyiFYGmQ9EnlHZB6jkYZBxGmGiRabSWqYCr1CqeK7gBY5FUtRuGWzHA1mSrZBcIVkVePQq4qDn5uSHIsACwSScQBVjsbUTcQiWvkpRj087XgZCmuJYEevjCqTAt0w0PKdDxUjkh84BCu9Mh"
    }
    headers = {
        "accept": "text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,"
                  "application/signed-exchange;v=b3;q=0.7",
        "accept-language": "en-US,en;q=0.9",
        "cache-control": "max-age=0",
        "sec-ch-ua": "\"Not.A/Brand\";v=\"8\", \"Chromium\";v=\"114\", \"Microsoft Edge\";v=\"114\"",
        "sec-ch-ua-mobile": "?0",
        "sec-ch-ua-platform": "\"Windows\"",
        "sec-fetch-dest": "document",
        "sec-fetch-mode": "navigate",
        "sec-fetch-site": "none",
        "sec-fetch-user": "?1",
        "upgrade-insecure-requests": "1"
    }
    cookies = {
        "datr": "klN9ZNqzHYGqmjROcL8GZ4Is",
        "sb": "vlN9ZIvcwjGp2abcnr4vAzvz",
        "c_user": "100057815212669",
        "m_page_voice": "100057815212669",
        "wd": "1865x929",
        "xs": "12%3ASn0z_ZAKdXJ85w%3A2%3A1686530376%3A-1%3A6315%3A%3AAcXju97MwsSZCKj4T3c8VcwSFVHdbM5bc_JiA9QLB8E",
        "presence": "C%7B%22lm3%22%3A%22u.100089831266162%22%2C%22t3%22%3A%5B%7B%22i%22%3A%22u.100011619888472%22%7D"
                    "%2C%7B%22i%22%3A%22u.100083326174240%22%7D%2C%7B%22i%22%3A%22u.100078985068883%22%7D%2C%7B%22i"
                    "%22%3A%22u.100024461437551%22%7D%5D%2C%22utc3%22%3A1687233056402%2C%22v%22%3A1%7D",
        "fr": "0z2YBktVDFHC62r00.AWWVJxaCcrsS5USiYyd2v7OImT4.BkkSFn.N5.AAA.0.0.BkkSYY.AWXS3KQHDtM",
        "usida": "eyJ2ZXIiOjEsImlkIjoiQXJ3ajl1bXVndDQ2dyIsInRpbWUiOjE2ODcyMzQ0MDF9"
    }

    response = requests.get(url, params=params, headers=headers, cookies=cookies)
    data = response.json()

    posts_data = []
    for post in data.get("data", []):
        id_ = post.get('id')
        message = post.get('description')
        if message:
            posts_data.append((id_, message))

    return posts_data


# Lấy dữ liệu bài đăng từ Facebook
posts_data = get_facebook_posts()

product_keywords = ["găng tay", "đồ BHLĐ", "áo thun", "áo ghi lê", "mũ", "quần áo", 'HP', 'DELL']

# Khởi tạo một đối tượng PostAnalyzer và phân loại người dùng
analyzer = PostAnalyzer(posts_data, product_keywords)
user_type = analyzer.classify_user()
analyzer.analyze_posts()
print(f"Người dùng được phân loại là: {user_type}")
