import os
import sys
import json

# Disable hash randomization
os.environ['PYTHONHASHSEED'] = '0'

# Disable numpy's parallel processing
os.environ['MKL_NUM_THREADS'] = '1'
os.environ['NUMEXPR_NUM_THREADS'] = '1'
os.environ['OMP_NUM_THREADS'] = '1'

try:
    # Kiểm tra tham số đầu vào
    if len(sys.argv) < 2:
        raise Exception("Thiếu tham số đầu vào")

    # Parse input JSON từ tham số
    input_data = json.loads(sys.argv[1])

    # Validate input data
    required_fields = ['precipitation', 'temp_max', 'temp_min', 'wind']
    for field in required_fields:
        if field not in input_data:
            raise Exception(f"Thiếu trường {field}")

    # Chuẩn bị dữ liệu
    precipitation = float(input_data['precipitation'])
    temp_max = float(input_data['temp_max'])
    temp_min = float(input_data['temp_min'])
    wind = float(input_data['wind'])

    # Logic dự đoán thời tiết dựa trên dataset
    if precipitation == 0 and temp_max > 25:  # Ngày nắng nóng không mưa
        weather = 'Sun (Nắng)'
    elif precipitation > 15:  # Mưa lớn
        if temp_max < 5:  # Nhiệt độ thấp
            weather = 'Snow (Tuyết)'
        else:
            weather = 'Rain (Mưa)'
    elif precipitation > 0 and precipitation <= 1:  # Mưa nhỏ
        if temp_max < 10:  # Nhiệt độ thấp
            weather = 'Snow (Tuyết)'
        else:
            weather = 'Drizzle (Rơi mưa rất nhỏ)'
    elif precipitation > 1 and precipitation <= 15:  # Mưa vừa
        weather = 'Rain (Mưa)'
    elif precipitation == 0 and temp_max < 15:  # Không mưa, nhiệt độ thấp
        if wind < 2:  # Gió nhẹ
            weather = 'Fog (Sương mù)'
        else:
            weather = 'Sun (Nắng)'
    elif precipitation == 0:  # Không mưa
        if wind < 2 and temp_min > 10:  # Gió nhẹ và ấm
            weather = 'Fog (Sương mù)'
        else:
            weather = 'Sun (Nắng)'
    else:
        weather = 'Sun (Nắng)'  # Mặc định là nắng

    # Trả kết quả
    print(json.dumps({
        'success': True,
        'prediction': weather,
        'data': {
            'precipitation': precipitation,
            'temp_max': temp_max,
            'temp_min': temp_min,
            'wind': wind
        }
    }))

except Exception as e:
    print(json.dumps({
        'success': False,
        'error': str(e)
    }), file=sys.stderr)
    sys.exit(1)
