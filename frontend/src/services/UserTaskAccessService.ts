import api from "./api";

class UserTaskAccessService {
    constructor() {
        const accessToken = localStorage.getItem("access_token");
        if (!accessToken) {
            throw new Error("Access token não encontrado no localStorage.");
        }

        api.defaults.headers.common["Authorization"] = `Bearer ${accessToken}`;
    }

    async store(payload: Record<string, any>) {
        const response = await api.post("/user-task-access", payload);
        console.log(response);
        return response.data;
    }
}

export default UserTaskAccessService;