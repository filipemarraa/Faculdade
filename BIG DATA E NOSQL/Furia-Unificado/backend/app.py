from flask import Flask, request, jsonify
import redis
import json
from flask_cors import CORS

app = Flask(__name__)
CORS(app)

r = redis.Redis(host='redis', port=6379, decode_responses=True)

@app.route('/chat', methods=['POST'])
def add_message():
    data = request.json
    message = {
        'username': data.get('username'),
        'text': data.get('text'),
        'timestamp': data.get('timestamp')
    }
    r.lpush('chat:torcida', json.dumps(message))
    return jsonify({"status": "ok"})

@app.route('/chat', methods=['GET'])
def get_messages():
    messages = r.lrange('chat:torcida', 0, 49)
    return jsonify([json.loads(m) for m in messages])

@app.route('/')
def root():
    return "API do Chat da FURIA funcionando!"

if __name__ == '__main__':
    app.run(debug=True, host='0.0.0.0')
