<!DOCTYPE html>
<html lang="ko">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>광고 홈페이지</title>
  <!-- Tailwind CSS CDN -->
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50">
  <!-- 헤더 -->
  <header class="bg-gradient-to-r from-blue-300 to-purple-300 text-black px-4 sm:px-8 py-4 sm:py-6 shadow">
    <!-- 전체 컨테이너를 3열 그리드로 구성 -->
    <div class="max-w-screen-2xl mx-auto grid grid-cols-3 items-center">
      <!-- 왼쪽 영역: 로고 -->
      <div>
        <div class="text-2xl sm:text-3xl font-bold whitespace-nowrap">
          광고 홈페이지
        </div>
      </div>
      <!-- 중앙 영역: 검색창 및 버튼 (조금 더 오른쪽으로 이동) -->
      <div class="flex justify-end pr-8">
        <!-- 검색창과 버튼을 포함하는 컨테이너 -->
        <div class="flex items-center space-x-3 w-96">
          <!-- 검색 입력창 -->
          <input id="searchInput" type="text" placeholder="검색어를 입력하세요"
                 class="flex-1 p-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-500 text-black w-72" />
          <!-- 검색 버튼 -->
          <button id="searchButton" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">
            검색
          </button>
        </div>
      </div>
      <!-- 오른쪽 영역: 내비게이션 -->
      <nav class="flex justify-end space-x-4 sm:space-x-6">
        <a href="#" class="whitespace-nowrap hover:text-blue-200 text-sm sm:text-base">로그인</a>
        <a href="#" class="whitespace-nowrap hover:text-blue-200 text-sm sm:text-base">아이디 / 비밀번호 찾기</a>
        <a href="#" class="whitespace-nowrap hover:text-blue-200 text-sm sm:text-base">마이페이지</a>
      </nav>
    </div>
  </header>
</body>
</html>
