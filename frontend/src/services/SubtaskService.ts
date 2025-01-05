import api from "./api";

class SubtaskService {
    constructor() {
        const accessToken = localStorage.getItem("access_token");
        if (!accessToken) {
            throw new Error("Access token não encontrado no localStorage.");
        }

        api.defaults.headers.common["Authorization"] = `Bearer ${accessToken}`;
    }

    async storeSubtask(subtaskData: Record<string, any>) {
        const response = await api.post("/subtask", subtaskData);
        return response.data;
    }

    async updateSubtask(subtaskData: Record<string, any>) {
        const response = await api.put("/subtask", subtaskData);
        return response.data;
    }
}

export default SubtaskService;