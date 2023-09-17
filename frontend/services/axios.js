import axios from "axios";

const instance = axios.create({
  baseURL: "https://localhost:8000",
  headers: {
    accept: "application/json",
  },
});

export default instance;
