import re
import json
import random
import pickle
from fastapi import FastAPI
from fastapi.middleware.cors import CORSMiddleware
from pydantic import BaseModel
from text_cleaner import clean_text

app = FastAPI()
app.add_middleware(
    CORSMiddleware,
    allow_origins=["*"],
    allow_credentials=True,
    allow_methods=["*"],
    allow_headers=["*"],
)

# Load model & label encoder
with open("chatbot_model.pkl", "rb") as f:
    model = pickle.load(f)

with open("label_encoder.pkl", "rb") as f:
    label_encoder = pickle.load(f)

# Load intent data
with open("dataset_ginjal_2_85_nlp.json", "r", encoding="utf-8") as f:
    data = json.load(f)

responses_dict = {
    intent["tag"]: intent.get("responses", ["Maaf, saya tidak mengerti."])
    for intent in data["intents"]
}

class ChatRequest(BaseModel):
    message: str

@app.post("/chatbot")
async def chatbot(req: ChatRequest):
    user_input = req.message
    cleaned_input = clean_text(user_input)

    pred_label_encoded = model.predict([cleaned_input])[0]
    pred_tag = label_encoder.inverse_transform([pred_label_encoded])[0]

    numbers = re.findall(r'\d+(?:\.\d+)?', user_input)
    parsed_value = float(numbers[0]) if numbers else None
    parsed_color_value = None

    # === Cek khusus untuk warna urine ===
    if pred_tag == "input_warna_urine":
        warna_keywords = ["kuning", "jernih", "keruh"]
        for warna in warna_keywords:
            if warna in user_input.lower():
                parsed_color_value = warna
                break
        response = (
            f"Warna urine '{parsed_color_value}' sudah dicatat."
            if parsed_color_value
            else "Mohon sebutkan warna urine seperti kuning, jernih, atau keruh."
        )

    elif pred_tag.startswith("input_"):
        response = f"{pred_tag.replace('input_', '').capitalize()} sudah dicatat."

    elif pred_tag == "closing":
        response = "Terima kasih, kita lanjut ke beberapa pertanyaan ya/tidak."

    else:
        response = random.choice(responses_dict.get(pred_tag, ["Maaf, saya tidak mengerti."]))

    return {
        "tag": pred_tag,
        "response": response,
        "parsed_value": parsed_value,
        "parsed_color_value": parsed_color_value
    }

