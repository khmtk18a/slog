/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./frontend/**/*.vue",
    "./assets/**/*.{js,vue}",
  ],
  theme: {
    extend: {
      colors: {
        "normal-bg": "#F0FDF4",
        "normal-btn-hover": "#DCFCE7",
        "normal-btn-bg": "#BBF7D0",
        "normal-btn-active": "#86EFAC",
        "normal-text-color": "#64748B",
        "title-text-color": "#475569",
        "green-btn-text-color": "#4ADE80",
        "green-btn-bg-color": "#86EFAC",
        "error-color": "#DC2626",
        "line-color": "#0080001a",
        "border-color": "#CBD5E1",
        "overlay-color": "#00000033",
      },
    },
  },
  plugins: [require("@tailwindcss/typography")]
}
