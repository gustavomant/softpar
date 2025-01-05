<template>
    <q-page padding>
        <div class="signup-container">
            <q-card class="signup-card">
                <q-card-section>
                    <div class="text-h6">Registro</div>
                </q-card-section>

                <q-card-section>
                    <q-input
                        v-model="name"
                        label="Nome"
                        outlined
                        dense
                        :rules="[rules.required]"
                    />
                    <q-input
                        v-model="email"
                        label="Email"
                        type="email"
                        outlined
                        dense
                        :rules="[rules.required, rules.email]"
                    />
                    <q-input
                        v-model="password"
                        label="Senha"
                        type="password"
                        outlined
                        dense
                        :rules="[rules.required]"
                    />
                </q-card-section>

                <q-card-actions>
                    <q-btn
                        label="Sign Up"
                        color="primary"
                        @click="handleSignUp"
                    />
                </q-card-actions>
            </q-card>
        </div>
    </q-page>
</template>

<script setup lang="ts">
import { ref } from "vue";
import { useRouter } from "vue-router";
import AuthenticationService from "../services/AuthenticationService";

const name = ref("");
const email = ref("");
const password = ref("");

const router = useRouter();

const rules = {
    required: (val: string) => !!val || "O campo é obrigatório",
    email: (val: string) =>
        /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(val) || "E-mail inválido",
};

const handleSignUp = async () => {
    try {
        if (!name.value || !email.value || !password.value) {
            alert("Por favor preencha todos os campos.");
            return;
        }

        const response = await AuthenticationService.signup(name.value, email.value, password.value);
        const token = response.data.access_token;

        localStorage.setItem("access_token", token);

        router.push("/");
    } catch (error) {
        console.error("Sign-up failed:", error);
        alert("Falha na inscrição. Por favor, tente novamente.");
    }
};
</script>

<style scoped>
.signup-container {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100%;
}

.signup-card {
    width: 400px;
}
</style>
