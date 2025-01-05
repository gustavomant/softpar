import api from "./api";

class TaskService {
    constructor() {
        const accessToken = localStorage.getItem("access_token");
        if (!accessToken) {
            throw new Error("Access token não encontrado no localStorage.");
        }

        api.defaults.headers.common["Authorization"] = `Bearer ${accessToken}`;
    }

    async getTasks() {
        const response = await api.get("/task");
        return response.data;
    }

    async getTaskDetails(id: number) {
        const response = await api.get(`/task/${id}`);
        return response.data;
    }

    async storeTask(taskData: Record<string, any>) {
        const response = await api.post("/task", taskData);
        return response.data;
    }

    async updateTask(taskData: Record<string, any>) {
        const response = await api.put("/task", taskData);
        console.log(response);
        return response.data;
    }
}

export default TaskService;
