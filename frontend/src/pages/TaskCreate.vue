<template>
    <q-page padding>
        <q-form @submit="createTask" class="q-pa-md">
            <q-input v-model="task.title" label="Título" required />
            <q-input v-model="task.subtitle" label="Subtítulo" required />
            <q-input v-model="task.description" label="Descrição" type="textarea" required />
            <q-input v-model="task.due_date" label="Prazo" type="date" required />

            <div class="q-mt-md" style="display: flex; justify-content: flex-end;">
                <q-btn type="submit" label="Criar Task" color="green" />
            </div>
        </q-form>

        <div v-if="loading">Criando tarefa...</div>
        <div v-if="error" class="text-negative">{{ error }}</div>
    </q-page>
</template>

<script setup lang="ts">
import { ref } from "vue";
import TaskService from "../services/TaskService";

const task = ref({
    title: "",
    subtitle: "",
    description: "",
    due_date: "",
});

const loading = ref(false);
const error = ref<string | null>(null);

const taskService = new TaskService();

const createTask = async () => {
    loading.value = true;
    error.value = null;

    try {
        await taskService.storeTask(task.value);

        task.value = { title: "", subtitle: "", description: "", due_date: "" };
    } catch (err) {
        error.value = "Erro ao criar a tarefa. Tente novamente.";
        console.error("Erro ao criar tarefa:", err);
    } finally {
        loading.value = false;
    }
};
</script>
