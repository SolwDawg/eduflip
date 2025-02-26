"use client";

import { useMutation } from "@tanstack/react-query";
import { loginApi } from "@/api/auth-api";
import { useAuthStore } from "@/store/auth-store";
import { useRouter } from "next/navigation";
import { Toaster } from "@/components/ui/sonner";

export const useLogin = () => {
  const router = useRouter();
  const { setUser, setIsAuthenticated } = useAuthStore();

  const loginMutation = useMutation({
    mutationFn: ({ email, password }: { email: string; password: string }) =>
      loginApi(email, password),
    onSuccess: (data) => {
      setUser(data.user);
      setIsAuthenticated(true);
      router.push("/dashboard");
    },
    onError: (error: Error) => {
      if (error.message === "Session expired. Please try again.") {
        // toast({
        //   title: "Session Expired",
        //   description: "Your session has expired. Please try logging in again.",
        //   variant: "destructive",
        // });
      } else {
        // toast({
        //   title: "Login Error",
        //   description: error.message,
        //   variant: "destructive",
        // });
      }
    },
  });

  return loginMutation;
};
