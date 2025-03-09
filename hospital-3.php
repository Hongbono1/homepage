<?php
// hospital-3.php
session_start();
require_once 'C:\xampp\htdocs\public\db.php'; // MySQL 연결

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // 폼 데이터 수집
  $businessName   = $_POST['businessName'] ?? ''; // 추가된 상호 필드
  $businessType   = $_POST['businessType'] ?? '';
  $deliveryOption = $_POST['deliveryOption'] ?? '';
  $businessHours  = $_POST['businessHours'] ?? '';
  $serviceDetails = $_POST['serviceDetails'] ?? '';
  $event1         = $_POST['event1'] ?? '';
  $event2         = $_POST['event2'] ?? '';
  $facility       = $_POST['facility'] ?? '';
  $pets           = $_POST['pets'] ?? '';
  $parking        = $_POST['parking'] ?? '';
  $phoneNumber    = $_POST['phoneNumber'] ?? '';
  $homepage       = $_POST['homepage'] ?? '';
  $additionalDesc = $_POST['additionalDesc'] ?? '';
  $postalCode     = $_POST['postalCode'] ?? '';
  $roadAddress    = $_POST['roadAddress'] ?? '';
  $detailAddress  = $_POST['detailAddress'] ?? '';

  // MySQL 저장 (mysqli로 변경)
  $sql = "INSERT INTO hospital_info 
    (name, category, delivery, open_hours, service_details, event1, event2, facility, pets, parking, phone, homepage, additional_desc, postal_code, road_address, detail_address) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

  $stmt = $conn->prepare($sql);
  $stmt->bind_param(
    "ssssssssssssssss",
    $businessName,
    $businessType,
    $deliveryOption,
    $businessHours,
    $serviceDetails,
    $event1,
    $event2,
    $facility,
    $pets,
    $parking,
    $phoneNumber,
    $homepage,
    $additionalDesc,
    $postalCode,
    $roadAddress,
    $detailAddress
  );

  if ($stmt->execute()) {
    echo "병원 정보가 성공적으로 저장되었습니다!";
    header("Location: list.php"); // 저장 후 리스트 페이지로 이동
    exit;
  } else {
    echo "오류 발생: " . $stmt->error;
  }
  $stmt->close();
  $conn->close();
}
?>


<!DOCTYPE html>
<html lang="ko">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>정보 입력 - 동적 서비스 페이지</title>
  <!-- Tailwind CSS CDN (개발/테스트용) -->
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- 다음 우편번호 검색 API -->
  <script src="https://t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
  <!-- 카카오 지도 API (YOUR_APP_KEY를 실제 키로 교체) -->
  <script type="text/javascript" src="https://dapi.kakao.com/v2/maps/sdk.js?appkey=YOUR_APP_KEY&libraries=services"></script>
</head>

<body class="bg-gray-200 flex flex-col min-h-screen">
  <?php include __DIR__ . '/components/header.php'; ?>
  <main class="flex-grow container mx-auto px-4 py-8">
    <!-- 컨텐츠 영역 (최대 너비 max-w-4xl, 중앙 정렬) -->
    <div id="commonContent" class="bg-white w-full max-w-4xl p-6 rounded-lg shadow-lg border-2 border-gray-300 mx-auto">
      <!-- 제목: 중앙 정렬 -->
      <div class="flex justify-center items-center mb-6">
        <h2 class="text-3xl font-bold text-gray-800">정보 입력</h2>
      </div>

      <!-- 입력 폼 시작 -->
      <form id="businessForm" method="post" action="hospital-3.php" class="space-y-6">
        <!-- 기본 정보 -->
        <div class="border rounded p-4 bg-gray-50">
          <h2 class="text-xl font-semibold mb-4">기본 정보</h2>
          <div class="flex flex-col md:flex-row md:items-center mb-3">
            <label for="businessName" class="w-32 font-medium">상호</label>
            <input type="text" id="businessName" name="businessName" placeholder="ex) OO 식당, 카페 XX 등"
              class="flex-1 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-200" />
          </div>
          <div class="flex flex-col md:flex-row md:items-center mb-3">
            <label for="businessType" class="w-32 font-medium">업종</label>
            <input type="text" id="businessType" name="businessType" placeholder="ex) 음식점, 카페, 기타"
              class="flex-1 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-200" />
          </div>
          <div class="flex flex-col md:flex-row md:items-center mb-3">
            <label for="deliveryOption" class="w-32 font-medium">배송/테이크아웃</label>
            <select id="deliveryOption" name="deliveryOption"
              class="mt-1 md:mt-0 flex-1 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-200">
              <option value="가능">가능</option>
              <option value="불가능">불가능</option>
            </select>
          </div>
          <div class="flex flex-col md:flex-row md:items-center">
            <label for="businessHours" class="w-32 font-medium">영업시간</label>
            <input type="text" id="businessHours" name="businessHours" placeholder="ex) 09:00 ~ 22:00"
              class="flex-1 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-200" />
          </div>
        </div>

        <!-- 서비스 내용 -->
        <div class="border rounded p-4 bg-gray-50">
          <h2 class="text-xl font-semibold mb-4">서비스 내용</h2>
          <textarea id="serviceDetails" name="serviceDetails"
            placeholder="서비스 관련 상세 설명, 메뉴, 예약 정보 등을 입력하세요."
            class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-200" rows="4"></textarea>
        </div>

        <!-- 고객 이벤트 -->
        <div class="border rounded p-4 bg-gray-50">
          <h2 class="text-xl font-semibold mb-4">고객 이벤트</h2>
          <div class="mb-3">
            <label for="event1" class="block font-medium mb-1">이벤트 내용 1</label>
            <input type="text" id="event1" name="event1" placeholder="이벤트 내용 1"
              class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-200" />
          </div>
          <div>
            <label for="event2" class="block font-medium mb-1">이벤트 내용 2</label>
            <input type="text" id="event2" name="event2" placeholder="이벤트 내용 2"
              class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-200" />
          </div>
        </div>

        <!-- 기타 정보: 장애인 편의시설, 반려동물 출입, 주차정보 -->
        <div class="border rounded p-4 bg-gray-50">
          <h2 class="text-xl font-semibold mb-4">기타 정보</h2>
          <div class="flex flex-col md:flex-row md:items-center mb-3">
            <label for="facility" class="w-32 font-medium">장애인 편의시설</label>
            <input type="text" id="facility" name="facility" placeholder="예: 있음 / 없음 / 간단 설명"
              class="flex-1 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-200" />
          </div>
          <div class="flex flex-col md:flex-row md:items-center mb-3">
            <label for="pets" class="w-32 font-medium">반려동물 출입</label>
            <input type="text" id="pets" name="pets" placeholder="예: 가능(소형견만) / 불가능 등"
              class="flex-1 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-200" />
          </div>
          <div class="flex flex-col md:flex-row md:items-center">
            <label for="parking" class="w-32 font-medium">주차정보</label>
            <input type="text" id="parking" name="parking" placeholder="예: 전용주차장 / 유료주차 / 불가능 등"
              class="flex-1 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-200" />
          </div>
        </div>

        <!-- 품목 입력 (최대 20개): 이미지, 품목 이름, 가격 -->
        <div class="border rounded p-4 bg-gray-50">
          <h2 class="text-xl font-semibold mb-4">품목 입력 (최대 20개)</h2>
          <div id="itemList" class="space-y-4"></div>
          <button type="button" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded" onclick="addItem()">+</button>
        </div>

        <!-- 연락처 -->
        <div class="border rounded p-4 bg-gray-50">
          <h2 class="text-xl font-semibold mb-4">연락처</h2>
          <div class="flex flex-col md:flex-row md:items-center mb-3">
            <label for="phoneNumber" class="w-32 font-medium">대표전화</label>
            <input type="text" id="phoneNumber" name="phoneNumber" placeholder="ex) 02-123-4567"
              class="flex-1 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-200" />
          </div>
          <div class="flex flex-col md:flex-row md:items-center">
            <label for="homepage" class="w-32 font-medium">홈페이지/블로그</label>
            <input type="text" id="homepage" name="homepage" placeholder="URL을 입력하세요"
              class="flex-1 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-200" />
          </div>
        </div>

        <!-- 추가 설명 -->
        <div class="border rounded p-4 bg-gray-50">
          <h2 class="text-xl font-semibold mb-4">추가 설명</h2>
          <textarea id="additionalDesc" name="additionalDesc" placeholder="추가 설명을 입력하세요."
            class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-200" rows="4"></textarea>
        </div>

        <!-- 이미지 등록 (최대 3장) -->
        <div class="border rounded p-4 bg-gray-50">
          <h2 class="text-xl font-semibold mb-4">이미지 등록 (최대 3장)</h2>
          <input type="file" id="imagesInput" name="images[]" accept="image/*" multiple
            class="block w-full mb-3 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:bg-blue-100 file:text-blue-700 hover:file:bg-blue-200" />
          <div id="imagesPreview" class="flex gap-3"></div>
        </div>

        <!-- 주소 입력 (우편번호, 도로명, 상세주소, 지도) -->
        <div class="border rounded p-4 bg-gray-50">
          <h2 class="text-xl font-semibold mb-4">주소 입력</h2>
          <!-- 우편번호 및 주소 검색 버튼 -->
          <div class="flex flex-col md:flex-row md:items-center gap-2 mb-3">
            <label for="postalCode" class="w-32 font-medium">우편번호</label>
            <input type="text" id="postalCode" name="postalCode" placeholder="우편번호" readonly
              class="flex-1 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-200" />
            <button type="button" onclick="openDaumPostcode()"
              class="bg-blue-500 hover:bg-blue-600 text-white font-semibold px-4 py-2 rounded">
              주소 찾기
            </button>
          </div>
          <!-- 도로명 주소 -->
          <div class="flex flex-col md:flex-row md:items-center gap-2 mb-3">
            <label for="roadAddress" class="w-32 font-medium">도로명 주소</label>
            <input type="text" id="roadAddress" name="roadAddress" placeholder="도로명 주소" readonly
              class="flex-1 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-200" />
          </div>
          <!-- 상세 주소 -->
          <div class="flex flex-col md:flex-row md:items-center gap-2">
            <label for="detailAddress" class="w-32 font-medium">상세 주소</label>
            <input type="text" id="detailAddress" name="detailAddress" placeholder="상세 주소를 입력하세요"
              class="flex-1 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-200" />
          </div>
          <!-- 지도 영역 -->
          <div id="map" class="mt-4 w-full h-64 border border-gray-300 rounded"></div>
        </div>

        <!-- 제출 및 수정 버튼 영역 -->
        <div class="text-center space-x-4">
          <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-6 rounded">
            입력 완료
          </button>
          <button type="button" id="editButton" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-6 rounded" onclick="resetForm()">
            수정
          </button>
        </div>
      </form>
      <!-- 입력 폼 끝 -->
    </div>
  </main>
  <?php include __DIR__ . '/components/footer.php'; ?>

  <!-- JavaScript: 이미지 미리보기, 주소 검색/지도, 품목 입력, 수정 기능 -->
  <script>
    // (1) 이미지 미리보기 (최대 3장)
    const imagesInput = document.getElementById('imagesInput');
    const imagesPreview = document.getElementById('imagesPreview');
    imagesInput.addEventListener('change', () => {
      imagesPreview.innerHTML = '';
      const files = Array.from(imagesInput.files).slice(0, 3);
      files.forEach(file => {
        const reader = new FileReader();
        reader.onload = (e) => {
          const img = document.createElement('img');
          img.src = e.target.result;
          img.className = 'w-32 h-20 object-cover border border-gray-300 rounded';
          imagesPreview.appendChild(img);
        };
        reader.readAsDataURL(file);
      });
    });

    // (2) 다음 주소 검색: 주소 선택 시 우편번호 및 도로명 주소 자동 입력, 지도 업데이트, 상세 주소에 포커스
    function openDaumPostcode() {
      new daum.Postcode({
        oncomplete: function(data) {
          document.getElementById('postalCode').value = data.zonecode;
          document.getElementById('roadAddress').value = data.roadAddress;
          updateMap(data.roadAddress);
          document.getElementById('detailAddress').focus();
        }
      }).open();
    }

    // (3) 카카오 지도 표시 (주소 → 좌표 변환)
    let map;
    let marker;

    function updateMap(address) {
      const mapContainer = document.getElementById('map');
      if (!map) {
        map = new kakao.maps.Map(mapContainer, {
          center: new kakao.maps.LatLng(37.5665, 126.9780),
          level: 3
        });
      }
      const geocoder = new kakao.maps.services.Geocoder();
      geocoder.addressSearch(address, function(result, status) {
        if (status === kakao.maps.services.Status.OK) {
          const coords = new kakao.maps.LatLng(result[0].y, result[0].x);
          map.setCenter(coords);
          if (marker) {
            marker.setPosition(coords);
          } else {
            marker = new kakao.maps.Marker({
              map: map,
              position: coords
            });
          }
        }
      });
    }

    // 상세 주소 입력 후 blur 시: 도로명 주소 + 상세 주소로 지도 재갱신
    document.getElementById('detailAddress').addEventListener('blur', function() {
      const baseAddr = document.getElementById('roadAddress').value.trim();
      const detailAddr = this.value.trim();
      if (baseAddr !== '' || detailAddr !== '') {
        updateMap(baseAddr + ' ' + detailAddr);
      }
    });

    // (4) 품목 입력 기능: 최대 20개까지, "+" 버튼 클릭 시 품목 항목 추가
    let itemCount = 0;

    function addItem() {
      if (itemCount >= 20) {
        alert("최대 20개까지 입력할 수 있습니다.");
        return;
      }
      itemCount++;
      const itemList = document.getElementById('itemList');
      const itemDiv = document.createElement('div');
      itemDiv.className = "flex flex-col md:flex-row md:items-center gap-2 border p-2 rounded";

      // 이미지 입력
      const imageInput = document.createElement('input');
      imageInput.type = "file";
      imageInput.accept = "image/*";
      imageInput.className = "border border-gray-300 rounded px-2 py-1";

      // 품목 이름 입력
      const nameInput = document.createElement('input');
      nameInput.type = "text";
      nameInput.placeholder = "품목 이름";
      nameInput.className = "flex-1 border border-gray-300 rounded px-2 py-1";

      // 가격 입력
      const priceInput = document.createElement('input');
      priceInput.type = "number";
      priceInput.placeholder = "가격";
      priceInput.className = "w-32 border border-gray-300 rounded px-2 py-1";

      // 삭제 버튼
      const removeBtn = document.createElement('button');
      removeBtn.type = "button";
      removeBtn.textContent = "삭제";
      removeBtn.className = "bg-red-500 hover:bg-red-600 text-white font-semibold px-3 py-1 rounded";
      removeBtn.onclick = function() {
        itemDiv.remove();
        itemCount--;
      };

      itemDiv.appendChild(imageInput);
      itemDiv.appendChild(nameInput);
      itemDiv.appendChild(priceInput);
      itemDiv.appendChild(removeBtn);

      itemList.appendChild(itemDiv);
    }

    // (5) 수정 버튼: 폼 리셋 및 이미지 미리보기, 품목 목록 초기화
    function resetForm() {
      document.getElementById('businessForm').reset();
      imagesPreview.innerHTML = '';
      document.getElementById('itemList').innerHTML = '';
      itemCount = 0;
    }
  </script>
</body>

</html>