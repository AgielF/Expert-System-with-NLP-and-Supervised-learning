import json
import re
import pickle
import matplotlib.pyplot as plt
import nltk

from text_cleaner import clean_text
from sklearn.feature_extraction.text import TfidfVectorizer
from sklearn.preprocessing import LabelEncoder
from sklearn.pipeline import Pipeline
from sklearn.svm import LinearSVC
from sklearn.model_selection import train_test_split
from sklearn.metrics import classification_report, confusion_matrix, ConfusionMatrixDisplay


# === Download stopwords (jika belum) ===
nltk.download("stopwords")
from nltk.corpus import stopwords
stop_words = set(stopwords.words("indonesian"))

# === Tambahkan Sastrawi untuk stemming ===
from Sastrawi.Stemmer.StemmerFactory import StemmerFactory
factory = StemmerFactory()
stemmer = factory.create_stemmer()


# Kamus normalisasi kata gaul/singkatan
normalization_dict = {
    "ga": "tidak", "gak": "tidak", "tdk": "tidak", "dr": "dari", "utk": "untuk",
    "dg": "dengan", "aja": "saja", "bgt": "banget", "bkn": "bukan", "blm": "belum"
}

def normalize_text(text):
    for slang, formal in normalization_dict.items():
        text = re.sub(rf"\b{slang}\b", formal, text)
    return text

# === Fungsi cleaning + stemming ===


# === 1. Load dataset intents ===
with open("dataset_ginjal_2_85_nlp.json", "r") as f:
    data = json.load(f)

texts = []
labels = []

for intent in data["intents"]:
    for pattern in intent["patterns"]:
        texts.append(pattern)
        labels.append(intent["tag"])

# === 2. Encode labels ===
label_encoder = LabelEncoder()
y = label_encoder.fit_transform(labels)

# === 3. Split data ===
X_train, X_test, y_train, y_test = train_test_split(texts, y, test_size=0.2, random_state=42)

# === 4. Pipeline: TF-IDF + SVM Classifier ===
model = Pipeline([
    ('tfidf', TfidfVectorizer(preprocessor=clean_text, ngram_range=(1, 2))),
    ('clf', LinearSVC())
])

# === 5. Train the model ===
model.fit(X_train, y_train)

# === 6. Evaluate ===
y_pred = model.predict(X_test)

print("\n=== Classification Report ===\n")
print(classification_report(y_test, y_pred, target_names=label_encoder.classes_))

# === 7. Confusion Matrix ===
cm = confusion_matrix(y_test, y_pred)
disp = ConfusionMatrixDisplay(confusion_matrix=cm, display_labels=label_encoder.classes_)
disp.plot(xticks_rotation=90)
plt.title("Confusion Matrix")
plt.tight_layout()
plt.show()

# === 8. Save model and label encoder ===
with open("chatbot_model.pkl", "wb") as f:
    pickle.dump(model, f)

with open("label_encoder.pkl", "wb") as f:
    pickle.dump(label_encoder, f)

print("✅ Model and label encoder saved successfully.")
