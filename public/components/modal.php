<?php
// 이 부분은 필요한 경우에만 (오류 디버깅 시)
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>

<!-- 모달 오버레이 -->
<div id="modalOverlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden"></div>

<!-- 광고 상세 모달 (공통 모달) -->
<div id="commonModal" class="fixed inset-0 flex items-center justify-center z-50 hidden">
  <div class="bg-white w-11/12 md:w-[80%] h-[90vh] max-h-screen max-w-5xl p-6 rounded-lg shadow-lg overflow-y-auto border-2 border-gray-300">
    <!-- 모달 헤더: 중앙에 가게 이름, 우측에 닫기 버튼 -->
    <div class="flex justify-center items-center mb-4 relative">
      <h2 id="modalHeaderStoreName" class="text-3xl font-bold text-gray-800">가게 이름</h2>
      <button id="closeModalBtn" class="absolute right-0 text-gray-500 hover:text-gray-800 text-2xl font-bold">✕</button>
    </div>
    <!-- 모달 본문: 2열 그리드 -->
    <div class="grid grid-cols-2 gap-6 h-full">
      <!-- 왼쪽: 이미지 & 지도 영역 -->
      <div class="flex flex-col gap-6 h-full">
        <div class="bg-white border-2 border-gray-300 rounded shadow-lg flex-1 p-4 flex flex-col">
          <div id="imageSliderContainer" class="relative flex-1 overflow-hidden rounded mb-2">
            <img id="modalMainImage" src="https://via.placeholder.com/600x400" alt="광고 이미지"
                 class="w-full h-full object-cover rounded-lg select-none" draggable="false" />
            <button id="modalPrevBtn"
                    class="absolute left-2 top-1/2 transform -translate-y-1/2 bg-gray-800 bg-opacity-50
                           text-white rounded-full p-2 hover:bg-opacity-75">&lt;</button>
            <button id="modalNextBtn"
                    class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-gray-800 bg-opacity-50
                           text-white rounded-full p-2 hover:bg-opacity-75">&gt;</button>
          </div>
        </div>
        <div class="bg-white border-2 border-gray-300 rounded shadow-lg flex-1 p-4 flex flex-col">
          <div class="flex items-center">
            <h2 class="text-xl font-bold text-left">지도</h2>
            <span id="modalAddress" class="text-lg ml-2">서울특별시 강남구 역삼동 123-45</span>
          </div>
          <div class="flex-1 border-2 border-gray-300 bg-gray-200 rounded flex items-center justify-center text-gray-500">
            지도 영역 (카카오 API 연결 가능)
          </div>
        </div>
      </div>
      <!-- 오른쪽: 가게 정보 영역 -->
      <div class="bg-white border-2 border-gray-300 rounded shadow-lg h-full p-6">
        <!-- 기본 정보 영역 -->
        <div>
          <div class="bg-gray-50 p-4 rounded border-2 border-gray-300">
            <p class="text-xl mb-4">
              <strong>업종:</strong> <span id="modalCategory">과일/채소</span>
            </p>
            <p class="text-xl mb-4">
              <strong>배달 및 테이크아웃:</strong> <span id="modalDelivery">가능</span>
            </p>
            <p class="text-xl">
              <strong>영업시간:</strong> <span id="modalHours">09:00 ~ 22:00</span>
            </p>
          </div>
          <div class="bg-gray-50 p-4 rounded border-2 border-gray-300 mt-4">
            <h2 class="text-2xl font-bold mb-4">서비스 품목</h2>
            <textarea id="modalServiceItems" class="w-full p-3 border border-gray-300 rounded" rows="5" readonly>
신선한 사과, 유기농 채소, 제철 과일
            </textarea>
          </div>
          <div class="bg-gray-50 p-4 rounded border-2 border-gray-300 mt-4">
            <h2 class="text-2xl font-bold mb-4">이벤트</h2>
            <ul class="list-disc pl-6 text-xl text-gray-700 space-y-2">
              <li id="modalEvent1">이벤트 내용 1</li>
              <li id="modalEvent2">이벤트 내용 2</li>
            </ul>
          </div>
        </div>
        <!-- 추가 정보 영역 (스크롤 가능) -->
        <div class="overflow-y-auto mt-4" style="max-height: calc(100% - 300px);">
          <div class="bg-gray-50 p-4 rounded border-2 border-gray-300 mt-4">
            <ul class="list-disc pl-6 text-xl text-gray-700 space-y-2">
              <li>
                <strong>장애인 편의시설:</strong> <span id="modalFacilities">휠체어 경사로</span>
              </li>
              <li>
                <strong>반려동물 출입:</strong> <span id="modalPets">가능</span>
              </li>
              <li>
                <strong>주차정보:</strong> <span id="modalParking">가게 앞 주차 가능</span>
              </li>
            </ul>
          </div>
          <div class="bg-gray-50 p-4 rounded border-2 border-gray-300 mt-4">
            <ul class="list-disc pl-6 text-xl text-gray-700">
              <li>
                <strong>대표전화:</strong> <span id="modalPhone">02-123-4567</span>
              </li>
            </ul>
          </div>
          <div class="mt-4">
            <hr class="my-6 border-gray-400 border-2" />
            <h2 class="text-2xl font-bold mb-4">추가 설명</h2>
            <div id="modalHiddenFields"
                 class="hidden bg-gray-50 p-4 rounded border-2 border-gray-300 text-xl text-gray-800 h-[200px]">
              여기에 추가 설명이 들어갑니다.
            </div>
            <div class="mt-4 flex justify-center gap-4">
              <button id="modalToggleBtn"
                      class="bg-blue-500 text-white font-bold py-3 px-8 rounded-lg shadow-md hover:bg-blue-600 transition">
                더보기
              </button>
              <button id="modalToggleBtn2"
                      class="hidden bg-blue-500 text-white font-bold py-3 px-8 rounded-lg shadow-md
                             hover:bg-blue-600 transition">
                이전
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- 여기에 모달 JS 코드를 통합 -->
<script>
(function() {
  function initModal() {
    // 모달 관련 요소들 (모달 HTML에 정의된 ID와 일치해야 합니다)
    const modalOverlay = document.getElementById("modalOverlay");
    const commonModal = document.getElementById("commonModal");
    const closeModalBtn = document.getElementById("closeModalBtn");

    // 모달 헤더의 가게 이름
    const modalHeaderStoreName = document.getElementById("modalHeaderStoreName");
    const modalMainImage = document.getElementById("modalMainImage");
    const modalPrevBtn = document.getElementById("modalPrevBtn");
    const modalNextBtn = document.getElementById("modalNextBtn");
    const imageSliderContainer = document.getElementById("imageSliderContainer");

    // 기본 정보 영역
    const modalAddress = document.getElementById("modalAddress");
    const modalCategory = document.getElementById("modalCategory");
    const modalDelivery = document.getElementById("modalDelivery");
    const modalHours = document.getElementById("modalHours");
    const modalServiceItems = document.getElementById("modalServiceItems");
    const modalEvent1 = document.getElementById("modalEvent1");
    const modalEvent2 = document.getElementById("modalEvent2");
    const modalFacilities = document.getElementById("modalFacilities");
    const modalPets = document.getElementById("modalPets");
    const modalParking = document.getElementById("modalParking");
    // 추가 정보 토글 영역
    const modalHiddenFields = document.getElementById("modalHiddenFields");
    const modalToggleBtn = document.getElementById("modalToggleBtn");
    const modalToggleBtn2 = document.getElementById("modalToggleBtn2");
    // 대표전화 (예시로 추가)
    const modalPhone = document.getElementById("modalPhone");
    
    // 이미지 슬라이더 데이터
    let imageSources = [];
    let currentIndexImg = 0;

    function updateMainImage() {
      if (modalMainImage) {
        modalMainImage.src = imageSources[currentIndexImg];
      }
    }
    function nextImage() {
      if (imageSources.length > 0) {
        currentIndexImg = (currentIndexImg + 1) % imageSources.length;
        updateMainImage();
      }
    }
    function prevImage() {
      if (imageSources.length > 0) {
        currentIndexImg = (currentIndexImg - 1 + imageSources.length) % imageSources.length;
        updateMainImage();
      }
    }

    // 모달 닫기 함수
    function closeModal() {
      if (modalOverlay) modalOverlay.classList.add("hidden");
      if (commonModal) commonModal.classList.add("hidden");
    }

    // 닫기 이벤트
    if (modalOverlay) {
      modalOverlay.addEventListener("click", closeModal);
    }
    if (closeModalBtn) {
      closeModalBtn.addEventListener("click", closeModal);
    }
    document.addEventListener("keydown", function (event) {
      if (event.key === "Escape") {
        closeModal();
      }
    });

    // 토글 버튼 (더보기)
    if (modalToggleBtn) {
      modalToggleBtn.addEventListener("click", function() {
        modalHiddenFields.classList.remove("hidden");
        modalToggleBtn.classList.add("hidden");
        modalToggleBtn2.classList.remove("hidden");
      });
    }
    if (modalToggleBtn2) {
      modalToggleBtn2.addEventListener("click", function() {
        modalHiddenFields.classList.add("hidden");
        modalToggleBtn.classList.remove("hidden");
        modalToggleBtn2.classList.add("hidden");
      });
    }

    // 이미지 슬라이더 버튼
    if (modalNextBtn) {
      modalNextBtn.addEventListener("click", nextImage);
    }
    if (modalPrevBtn) {
      modalPrevBtn.addEventListener("click", prevImage);
    }
    // 드래그 슬라이드
    if (imageSliderContainer) {
      let startX = 0;
      let isDragging = false;
      imageSliderContainer.addEventListener("mousedown", function (e) {
        startX = e.pageX;
        isDragging = true;
      });
      imageSliderContainer.addEventListener("mouseup", function (e) {
        if (!isDragging) return;
        const diff = e.pageX - startX;
        if (Math.abs(diff) > 50) {
          diff < 0 ? nextImage() : prevImage();
        }
        isDragging = false;
      });
      imageSliderContainer.addEventListener("mouseleave", function () {
        isDragging = false;
      });
    }

    // 모달 데이터를 채워주는 함수
    function populateModal(data) {
      if (modalHeaderStoreName) modalHeaderStoreName.textContent = data.title || "가게 이름 없음";
      if (modalPhone) modalPhone.textContent = data.phone || "전화번호 없음";
      if (modalMainImage) {
        modalMainImage.src = data.image || "https://via.placeholder.com/600x400";
      }
      if (modalAddress) modalAddress.textContent = data.address || "주소 정보 없음";
      if (modalCategory) modalCategory.textContent = data.category || "업종 정보 없음";
      if (modalDelivery) modalDelivery.textContent = data.delivery || "배달/테이크아웃 정보 없음";
      if (modalHours) modalHours.textContent = data.hours || "영업시간 정보 없음";
      if (modalServiceItems) modalServiceItems.value = data.serviceItems || "";
      if (modalEvent1) modalEvent1.textContent = data.events && data.events[0] ? data.events[0] : "이벤트 없음";
      if (modalEvent2) modalEvent2.textContent = data.events && data.events[1] ? data.events[1] : "";
      if (modalFacilities) modalFacilities.textContent = data.facilities || "장애인 편의 시설 없음";
      if (modalPets) modalPets.textContent = data.pets || "반려동물 정보 없음";
      if (modalParking) modalParking.textContent = data.parking || "주차 정보 없음";

      // 슬라이더 이미지 배열
      if (data.sliderImages && Array.isArray(data.sliderImages) && data.sliderImages.length > 0) {
        imageSources = data.sliderImages;
        currentIndexImg = 0;
        updateMainImage();
      } else {
        // 만약 sliderImages가 없으면 현재 이미지 하나만 사용
        imageSources = [modalMainImage.src];
        currentIndexImg = 0;
      }

      // 모달 열기
      if (modalOverlay) modalOverlay.classList.remove("hidden");
      if (commonModal) commonModal.classList.remove("hidden");
    }

    // 전역 접근을 위해 window에 등록
    window.populateModal = populateModal;
    window.closeModal = closeModal;
  }

  // DOM이 다 로드된 후 모달 초기화
  document.addEventListener("DOMContentLoaded", function () {
    setTimeout(initModal, 100);
  });
})();
</script>
