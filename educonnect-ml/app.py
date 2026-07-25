from flask import Flask, request, jsonify
from sklearn.feature_extraction.text import TfidfVectorizer
from sklearn.naive_bayes import MultinomialNB
from sklearn.pipeline import Pipeline

app = Flask(__name__)

# Training data — expand this with real past discussion titles/content later
training_texts = [
    "how do I fix this python error in my code",
    "java function not compiling programming bug",
    "sql query joining two tables database",
    "mysql database schema design question",
    "network protocol tcp ip routing issue",
    "server connection failed networking problem",
    "software requirements gathering agile methodology",
    "system design uml diagram architecture",
    "general question about the course",
    "when is the assignment deadline",
]
training_labels = [
    "Programming", "Programming",
    "Database", "Database",
    "Networking", "Networking",
    "Software Engineering", "Software Engineering",
    "General", "General",
]

model = Pipeline([
    ('tfidf', TfidfVectorizer()),
    ('nb', MultinomialNB()),
])
model.fit(training_texts, training_labels)


@app.route('/classify', methods=['POST'])
def classify():
    data = request.get_json()
    title = data.get('title', '')
    content = data.get('content', '')
    text = f"{title} {content}"

    prediction = model.predict([text])[0]
    probabilities = model.predict_proba([text])[0]
    confidence = max(probabilities)

    return jsonify({
        'category': prediction,
        'confidence': round(float(confidence), 2),
    })


if __name__ == '__main__':
    app.run(port=5001, debug=True)