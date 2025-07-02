# text_cleaner.py

import re
from nltk.corpus import stopwords
from Sastrawi.Stemmer.StemmerFactory import StemmerFactory

# Stopwords dan stemmer
stop_words = set(stopwords.words("indonesian"))
stemmer = StemmerFactory().create_stemmer()

# Kamus normalisasi
normalization_dict = {
    "ga": "tidak", "gak": "tidak", "tdk": "tidak", "dr": "dari", "utk": "untuk",
    "dg": "dengan", "aja": "saja", "bgt": "banget", "bkn": "bukan", "blm": "belum"
}

def normalize_text(text):
    for slang, formal in normalization_dict.items():
        text = re.sub(rf"\b{slang}\b", formal, text)
    return text

def clean_text(text):
    text = text.lower()
    text = normalize_text(text)
    text = re.sub(r"[^a-zA-Z\s]", "", text)
    tokens = text.split()
    tokens = [stemmer.stem(word) for word in tokens if word not in stop_words]
    return " ".join(tokens)
