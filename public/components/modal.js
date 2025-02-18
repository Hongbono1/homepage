// modal.js
(function () {
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

    // 기본 정보 영역 (예시)
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

    // 모달 닫기 함수
    function closeModal() {
      modalOverlay.classList.add("hidden");
      commonModal.classList.add("hidden");
    }

    // 모달 닫기 이벤트 (오버레이 클릭, X 버튼, Esc 키)
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

    // 추가 정보 토글 기능
    if (modalToggleBtn) {
      modalToggleBtn.addEventListener("click", function () {
        modalHiddenFields.classList.remove("hidden");
        modalToggleBtn.classList.add("hidden");
        modalToggleBtn2.classList.remove("hidden");
      });
    }
    if (modalToggleBtn2) {
      modalToggleBtn2.addEventListener("click", function () {
        modalHiddenFields.classList.add("hidden");
        modalToggleBtn.classList.remove("hidden");
        modalToggleBtn2.classList.add("hidden");
      });
    }

    // 모달 내 이미지 슬라이더 기능
    let imageSources = [];
    let currentIndexImg = 0;

    function updateMainImage() {
      modalMainImage.src = imageSources[currentIndexImg];
    }

    function nextImage() {
      currentIndexImg = (currentIndexImg + 1) % imageSources.length;
      updateMainImage();
    }

    function prevImage() {
      currentIndexImg = (currentIndexImg - 1 + imageSources.length) % imageSources.length;
      updateMainImage();
    }

    if (modalNextBtn) {
      modalNextBtn.addEventListener("click", nextImage);
    }
    if (modalPrevBtn) {
      modalPrevBtn.addEventListener("click", prevImage);
    }
    

    // 이미지 드래그로 슬라이더 제어
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

    // 고객 데이터로 모달 내용을 자동 채우는 함수
    // data 객체 예시:
    // {
    //   title: "가게 이름",
    //   phone: "010-1234-5678",
    //   image: "https://example.com/image.jpg",
    //   address: "서울특별시 강남구 역삼동 123-45",
    //   category: "업종명",
    //   delivery: "가능",
    //   hours: "09:00 ~ 22:00",
    //   serviceItems: "상품 목록",
    //   events: ["이벤트 내용 1", "이벤트 내용 2"],
    //   facilities: "휠체어 경사로",
    //   pets: "가능",
    //   parking: "무료 주차",
    //   additionalInfo: "추가 설명 내용",
    //   sliderImages: ["https://example.com/image1.jpg", "https://example.com/image2.jpg"]
    // }
    function populateModal(data) {
      if (modalHeaderStoreName) modalHeaderStoreName.textContent = data.title || "가게 이름 없음";
      if (modalPhone) modalPhone.textContent = data.phone || "전화번호 없음";
      if (modalMainImage) {
        modalMainImage.src = data.image || "https://via.placeholder.com/600x400";
        modalMainImage.style.width = "600px";
        modalMainImage.style.height = "400px";
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
      if (modalAdditionalInfo) modalAdditionalInfo.textContent = data.additionalInfo || "추가 정보 없음";

      // 슬라이더 이미지 배열 업데이트 (sliderImages가 제공되면 사용)
      if (data.sliderImages && Array.isArray(data.sliderImages) && data.sliderImages.length > 0) {
        imageSources = data.sliderImages;
        currentIndexImg = 0;
        updateMainImage();
      } else if (modalMainImage) {
        // 기본적으로 현재 메인 이미지만 사용
        imageSources = [modalMainImage.src];
        currentIndexImg = 0;
        updateMainImage();
      }
    }

    // 전역에서 호출할 수 있도록 함
    window.populateModal = populateModal;
    window.closeModal = closeModal;
  }

  // DOMContentLoaded 이후 모달 HTML 요소들이 모두 로드된 것을 보장하기 위해 초기화
  document.addEventListener("DOMContentLoaded", function () {
    setTimeout(initModal, 100);
  });
})();
