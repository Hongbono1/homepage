<?php
// deliveryrider.php

// (선택) PHP 에러 표시
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>
<!DOCTYPE html>
<html lang="ko">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>🏍️ 배달 라이더 광고</title>
  <!-- Tailwind CSS CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 min-h-screen flex flex-col items-center">
  <!-- 헤더 로드 -->
  <?php include 'components/header.php'; ?>
`
  <!-- 헤더 아래 간격 추가 -->
  <div class="mt-20"></div>`

  <!-- 메인 제목 섹션 -->
  <section class="text-center mb-8">
    <h2 class="text-4xl font-ex`trabold text-green-700">🏍️ 배달 라이더 광고</h2>
    <p class="text-lg text-gray-600 mt-2">라이더가 제공하는 배달 서비스를 확인하세요!</p>
  </section>

  <!-- 배달 라이더 광고 섹션 -->
  <section id="riderSection" class="bg-white border-2 border-gray-300 rounded-lg p-6 mt-8 shadow relative w-full max-w-6xl px-4">
    <div class="flex items-center justify-between mb-6">
      <h2 class="text-3xl font-bold">가장 핫한 배달 라이더</h2>
      <a href="#" class="text-blue-500 text-lg font-semibold hover:underline transition">+더보기</a>
    </div>
    <!-- 광고 박스들을 감쌀 컨테이너 -->
    <div id="riderList"></div>
  </section>

  <!-- 모달 로드 -->
  <?php include 'components/modal.php'; ?>

  <!-- 푸터 위 간격 추가 -->
  <div class="mb-16"></div>

  <!-- 푸터 로드 -->
  <?php include 'components/footer.php'; ?>

  <!-- 자바스크립트: 라이더 광고 데이터 및 모달 연동 -->
  <script>
    // 라이더 데이터 예시
    const riders = Array.from({ length: 8 }, (_, i) => ({
      name: `🏍️ Rider ${i + 1}`,
      phone: `010-0000-000${i + 1}`,
      location: `대한민국 주소 ${i + 1}`,
      service: "비밀 트로트 배달 | 탑배 서비스",
      promotion: "🎉 초기 이용 10% 할인!",
      image: "https://via.placeholder.com/300x200"
    }));

    // 광고 박스 생성 함수
    function createAdBox(rider) {
      const box = document.createElement("div");
      box.className = "flex-1 bg-white border-2 border-gray-300 p-4 rounded-lg shadow-lg text-center transform transition hover:scale-105 flex flex-col justify-between cursor-pointer";
      box.innerHTML = `
        <img class="w-full h-40 object-cover rounded-t-lg" src="${rider.image}" alt="${rider.name}">
        <div class="p-4 flex flex-col flex-grow">
          <p class="text-gray-800 font-bold text-lg">${rider.name}</p>
          <p class="text-gray-500 mt-2">${rider.phone}</p>
          <p class="text-gray-400 mt-2">${rider.location}</p>
        </div>
      `;
      box.addEventListener("click", () => openRiderModal(rider));
      return box;
    }

    // 그룹 데이터 분할 (예시)
    const topRiders = riders.slice(0, 4);
    const bottomRiders = riders.slice(4, 8);

    // 그룹 컨테이너 생성
    function createGroupBox(groupRiders) {
      const groupBox = document.createElement("div");
      groupBox.className = "bg-gray-200 p-4 rounded-lg mb-6 flex-1";
      const topRow = document.createElement("div");
      topRow.className = "flex flex-row gap-6 mb-4";
      topRow.appendChild(createAdBox(groupRiders[0]));
      topRow.appendChild(createAdBox(groupRiders[1]));
      const bottomRow = document.createElement("div");
      bottomRow.className = "flex flex-row gap-6";
      bottomRow.appendChild(createAdBox(groupRiders[2]));
      bottomRow.appendChild(createAdBox(groupRiders[3]));
      groupBox.appendChild(topRow);
      groupBox.appendChild(bottomRow);
      return groupBox;
    }

    const groupLeft = [topRiders[0], topRiders[1], bottomRiders[0], bottomRiders[1]];
    const groupRight = [topRiders[2], topRiders[3], bottomRiders[2], bottomRiders[3]];

    const groupContainer = document.createElement("div");
    groupContainer.className = "flex flex-row gap-6 w-full";
    groupContainer.appendChild(createGroupBox(groupLeft));
    groupContainer.appendChild(createGroupBox(groupRight));
    document.getElementById("riderList").appendChild(groupContainer);

    // 모달 열기 함수
    function openRiderModal(rider) {
      setTimeout(() => {
        if (window.populateModal) {
          window.populateModal({
            title: rider.name,
            phone: rider.phone,
            image: rider.image,
            address: rider.location,
            category: "배달 라이더",
            delivery: "가능",
            hours: "24시간",
            serviceItems: rider.service,
            events: [rider.promotion, ""],
            facilities: "안전 헬멧 제공",
            pets: "불가능",
            parking: "무료 주차"
          });
          document.getElementById("modalOverlay").classList.remove("hidden");
          document.getElementById("commonModal").classList.remove("hidden");
        } else {
          console.error("populateModal 함수가 로드되지 않았습니다.");
        }
      }, 100);
    }

    // 모달 닫기 함수
    function closeRiderModal() {
      document.getElementById("modalOverlay").classList.add("hidden");
      document.getElementById("commonModal").classList.add("hidden");
    }

    // 모달 닫기 이벤트 등록 (옵션)
    setTimeout(() => {
      const modalOverlay = document.getElementById("modalOverlay");
      const closeModalBtn = document.getElementById("closeModalBtn");
      if (modalOverlay && closeModalBtn) {
        modalOverlay.addEventListener("click", closeRiderModal);
        closeModalBtn.addEventListener("click", closeRiderModal);
      }
    }, 300);
  </script>
</body>
</html>
