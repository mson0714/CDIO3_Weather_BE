import sys
import json
import joblib
import numpy as np
from sklearn.preprocessing import LabelEncoder

try:
    # Thiết lập seed cho numpy để tránh lỗi randomization
    np.random.seed(42)

    # Load model từ storage/app/
    model = joblib.load('storage/app/weather_prediction.pkl')

    # Đọc input từ PHP
    input_data = json.loads(sys.argv[1])

    # Chuẩn bị dữ liệu
    features = np.array([
        float(input_data['precipitation']),
        float(input_data['temp_max']),
        float(input_data['temp_min']),
        float(input_data['wind'])
    ]).reshape(1, -1)  # Reshape thành ma trận 2D

    # Dự đoán
    prediction = model.predict(features)

    # Trả kết quả về PHP
    print(json.dumps({'prediction': str(prediction[0])}))

except Exception as e:
    # Trả về lỗi nếu có
    error_message = str(e)
    print(json.dumps({'error': error_message}), file=sys.stderr)
    sys.exit(1)
