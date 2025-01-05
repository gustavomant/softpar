<template>
    <q-page padding>
        <div v-if="loading">Carregando...</div>
        <div v-else>
            <div class="q-pa-md" style="display: flex; justify-content: flex-end;">
                <q-btn 
                    color="green" 
                    label="Nova Task" 
                    @click="navigateToTaskCreate" 
                    flat
                />
            </div>
            <q-list bordered>
                <q-item
                    v-for="task in tasks"
                    :key="task.id"
                    :class="{'bg-grey-3': task.status === 'done'}"
                >
                    <q-item-section class="cursor-pointer" @click="navigateToTaskDetails(task.id)" >
                        <q-item-label>{{ task.title }}</q-item-label>
                        <q-item-label caption>{{ task.subtitle }}</q-item-label>
                        <q-item-label>{{ task.description }}</q-item-label>
                        <q-item-label caption>Prazo: {{ task.due_date }}</q-item-label>
                    </q-item-section>

                    <q-item-section side>
                        <q-btn
                            icon="check"
                            color="green"
                            @click="toggleTaskStatus(task)"
                            :disabled="task.status === 'removed'"
                        />
                        <q-btn
                            icon="delete"
                            color="red"
                            @click="deleteTask(task)"
                        />
                    </q-item-section>
                </q-item>
            </q-list>
        </div>
    </q-page>

    <q-dialog v-model="showDialog">
        <q-card>
            <q-card-section>
                <div class="text-h6">{{ dialogMessage }}</div>
            </q-card-section>
            <q-card-actions>
                <q-btn flat label="Fechar" color="primary" @click="showDialog = false" />
            </q-card-actions>
        </q-card>
    </q-dialog>
</template>

<script setup lang="ts">
import { ref, onMounted } from "vue";
import { useRouter } from "vue-router";
import TaskService from "../services/TaskService";

const taskService = new TaskService();

const tasks = ref<any[]>([]);
const loading = ref(true);
const router = useRouter();
const showDialog = ref(false);
const dialogMessage = ref('');

const loadTasks = async () => {
    try {
        tasks.value = await taskService.getTasks();
    } catch (error) {
        console.error("Erro ao carregar tarefas", error);
    } finally {
        loading.value = false;
    }
};

const toggleTaskStatus = async (task: Record<string, any>) => {
    try {
        const newStatus = task.status === "done" ? "pending" : "done";
        const taskData = { task_id: task.id, status: newStatus };
        const response = await taskService.updateTask(taskData);
        console.log("Status da tarefa alterado:", response);

        loadTasks();
    } catch (error: any) {
        if (error?.response?.status === 403) {
            dialogMessage.value = "Você não tem permissão para alterar o status dessa tarefa.";
        } else {
            dialogMessage.value = "Ocorreu um erro ao alternar o status da tarefa.";
        }
        
        showDialog.value = true;
    }
};

const deleteTask = async (task: Record<string, any>) => {
    try {
        const taskData = { task_id: task.id, status: "removed" };
        const response = await taskService.updateTask(taskData);

        loadTasks();
    } catch (error: any) {
        if (error?.response?.status === 403) {
            dialogMessage.value = "Você não tem permissão para alterar o status dessa tarefa.";
        } else {
            dialogMessage.value = "Ocorreu um erro ao alternar o status da tarefa.";
        }
        
        showDialog.value = true;
    }
};

const navigateToTaskDetails = (taskId: number) => {
    router.push(`${taskId}`);
}

const navigateToTaskCreate = () => {
    router.push("/task-create/");
}

onMounted(() => {
    loadTasks();
});
</script>

<style scoped>
    .q-item {
        border-bottom: 1px solid #ddd;
    }
</style>
