import api from "./api";

class AuthenticationService {
    static async signin(email: string, password: string) {
        const response = await api.post("/signin", { email, password });
        
        return response;
    }

    static async signup(name: string, email: string, password: string) {
        const response = await api.post("/signup", { name, email, password });
            
        return response;
    }
}

export default AuthenticationService;
