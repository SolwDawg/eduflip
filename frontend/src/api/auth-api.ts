import axiosClient from "./axios-client";
import axios from "axios";

export const loginApi = async (email: string, password: string) => {
  try {
    const response = await axiosClient.post("/auth/login", { email, password });
    return response.data;
  } catch (error) {
    if (axios.isAxiosError(error)) {
      if (error.response?.status === 419) {
        throw new Error("Session expired. Please try again.");
      }
      throw new Error(
        error.response?.data?.message || "An error occurred during login."
      );
    }
    throw error;
  }
};
