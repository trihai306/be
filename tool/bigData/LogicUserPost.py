import re
from typing import List, Dict, Tuple
from sklearn.feature_extraction.text import TfidfVectorizer


def extract_keywords(posts: List[str], top_n: int = 10) -> List[str]:
    vectorizer = TfidfVectorizer(stop_words='english', ngram_range=(1, 3))
    tfidf_matrix = vectorizer.fit_transform(posts)
    feature_names = vectorizer.get_feature_names_out()

    keyword_lists = []

    for i in range(len(posts)):
        row = tfidf_matrix.getrow(i).toarray()[0].ravel()
        top_indices = row.argsort()[-top_n:]
        keywords = [feature_names[ind] for ind in top_indices]
        keyword_lists.append(keywords)

    return keyword_lists


def classify_post(post: str, keywords: List[str]) -> Tuple[str, Dict[str, List[str]]]:
    seller_keywords = ['bán', 'giá', 'mua']
    buyer_keywords = ['cần mua', 'tìm', 'ai có','báo giá giúp']

    seller_score = sum([post.lower().count(keyword) for keyword in seller_keywords])
    buyer_score = sum([post.lower().count(keyword) for keyword in buyer_keywords])

    if seller_score > buyer_score:
        user_type = 'Người bán hàng'
    elif buyer_score > seller_score:
        user_type = 'Người mua hàng'
    else:
        user_type = 'Không xác định'

    return user_type, analyze_post(post, keywords)


def analyze_post(post: str, keywords: List[str]) -> Dict[str, List[str]]:
    abbreviations = ["LH", "SĐT", "ĐC", "FB", "Zalo", "Viber", "Ship", "COD"]
    phone_number_pattern = r"\b(0\d{9})\b"

    found_keywords = [keyword for keyword in keywords if keyword in post.lower()]
    found_abbreviations = [abbreviation for abbreviation in abbreviations if abbreviation.lower() in post.lower()]
    found_phone_numbers = re.findall(phone_number_pattern, post)
    repeated_words = detect_repeated_words(post)

    return {
        "keywords": found_keywords,
        "abbreviations": found_abbreviations,
        "phone_numbers": found_phone_numbers,
        "repeated_words": repeated_words
    }


def detect_repeated_words(post: str) -> List[str]:
    words = post.lower().split()
    repeated_words = [word for word in words if words.count(word) > 1]
    return list(set(repeated_words))


# Dữ liệu bài đăng
posts = [
    "Nhà mình ai bán quạt tích điện to 1 xíu chất lượng đắt xíu cũng được",
    "Nghe nói hôm nay chôm chôm rớt giá❤❤ Chủ cho phép bán rẻ cực rẻ bà con ơi Chỉ ##100kk/6kg chôm tươi rói, ngọt lịm , róc hạt Tách #55k/3kg Miễn ship kcn luôn ạ",
    "ai có điều hoà rẻ chút ko loại 9000. hoặc 12000 kv yên phong . báo giá giúp e",
    "E vừa về đx lô quạt NLMT,mời các bác lên đơn ạ,khoẻ mát,ảnh, video e tự quay ạ",
    "Cần mua sách tiếng Anh cho học sinh lớp 6, ai có giới thiệu giúp mình với",
    "Chuyên bán phụ kiện điện thoại chính hãng, giá cả hợp lý, bảo hành 1 đổi 1",
    "Hôm nay mình có việc gấp, ai biết nơi nào sửa xe tay ga uy tín không?",
    "Mình cần mua đồ chơi cho bé 3 tuổi, ưu tiên hàng Việt Nam chất lượng",
    "Khuyến mãi đặc biệt: Mua 1 tặng 1 cho đôi giày thể thao mới, nhanh tay đặt hàng!",
    "Ai biết chỗ nào bán cây cảnh đẹp ở Hà Nội không? Mình muốn trang trí văn phòng"
]


# Xác định từ khóa
keyword_lists = extract_keywords(posts)

# Phân tích bài đăng
for post, keywords in zip(posts, keyword_lists):
    print("-------")
    print("Bài đăng:", post)
    user_type, analysis_result = classify_post(post, keywords)
    print("Loại người dùng:", user_type)

    for key, values in analysis_result.items():
        if values:
            print(f"Tìm thấy {key}: {', '.join(values)}")
