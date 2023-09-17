<template>
  <div id="user-skeleton" class="relative z-0 w-[100%] rounded-[1rem] p-[1rem]">
    <div class="text-ntext flex justify-between">
      <div class="flex items-start">
        <div
          class="shine h-[2rem] w-[2rem] rounded-[2rem] bg-normal-btn-bg"
        ></div>
        <div
          class="shine ml-[0.5rem] h-[1.2rem] w-[5rem] rounded-[1rem] bg-normal-btn-bg"
        ></div>
        <span class="mx-[0.5rem]">•</span>
        <div
          class="shine h-[1.2rem] w-[3rem] rounded-[1rem] bg-normal-btn-bg"
        ></div>
      </div>
      <div
        class="shine h-[1.5rem] w-[4rem] rounded-[1rem] bg-normal-btn-bg"
      ></div>
    </div>
    <div
      class="shine mt-[0.5rem] h-[20rem] w-full rounded-[1rem] bg-normal-btn-bg"
    ></div>
  </div>
</template>

<style scoped>
.shine {
  background-image: linear-gradient(
    to left,
    rgb(220 252 231) 1%,
    white,
    rgb(220 252 231)
  );
  background-size: 300% 100%;
  background-position: right bottom;
  transition: all 3s cubic-bezier(0.4, 0, 1, 1);
}
@keyframes slideIn {
  0% {
    background-position: 300% 0;
  }
  100% {
    background-position: 150% 0;
  }
}

.shine {
  animation: slideIn 3s ease-in-out infinite;
}
</style>
