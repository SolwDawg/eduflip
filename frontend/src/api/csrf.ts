import axiosClient from "./axios-client";

export const fetchCsrfToken = async () => {
  const response = await axiosClient.get("/sanctum/csrf-token", {
    withCredentials: true,
  });
  axiosClient.defaults.headers.common["X-CSRF-TOKEN"] = response.data.csrfToken;
};