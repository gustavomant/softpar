<template>
    <q-page padding>
        <div v-if="loading">Carregando...</div>
        <div v-else>
            <q-page-pading>
                <h1 class="q-mb-md" style="font-size: 32px; font-weight: bold;">Detalhes da Tarefa</h1>
                <q-form @submit.prevent="updateTask">
                    <q-input v-model="task.title" label="Título" filled />
                    <q-input v-model="task.subtitle" label="Subtítulo" filled />
                    <q-input v-model="task.description" label="Descrição" filled />
                    <q-input v-model="task.due_date" label="Prazo" filled type="date" />
                    <div class="q-mt-md" style="display: flex; justify-content: flex-end;">
                        <q-btn label="Salvar" color="green" type="submit" />
                    </div>
                </q-form>
            </q-page-pading>
            
            <q-page-pading>
                <h1 class="q-mb-md" style="font-size: 32px; font-weight: bold;">Adicionar Usuário</h1>
                <q-form @submit.prevent="inviteUser">
                    <q-input v-model="userEmail" label="Email do usuário" filled type="email" :rules="[rules.required, rules.email]" />
                    
                    <q-select
                        v-model="accessType"
                        :options="accessTypes"
                        label="Tipo de Acesso"
                        filled
                        :rules="[rules.required]"
                    />

                    
                    <div class="q-mt-md" style="display: flex; justify-content: flex-end;">
                        <q-btn label="Convidar Usuário" color="primary" type="submit" />
                    </div>
                </q-form>
            </q-page-pading>
            
            <q-page-pading>
                <h1 class="q-mb-md" style="font-size: 32px; font-weight: bold;">Subtarefas</h1>
                <q-list bordered v-if="task.subtasks.length > 0" >
                    <SubtaskItem
                        v-for="subtask in task.subtasks"
                        :key="subtask.id"
                        :subtask="subtask"
                        @status-changed="handleStatusChanged" 
                        @subtask-deleted="handleSubtaskDeleted"   
                    />
                </q-list>
            </q-page-pading>
            
            <q-page-pading>
                <h1 class="q-mb-md" style="font-size: 32px; font-weight: bold;">Adicionar Tarefa</h1>
                <q-form @submit.prevent="saveSubtask">
                    <q-input v-model="newSubtask.title" label="Título Subtarefa" filled />
                    <q-input v-model="newSubtask.subtitle" label="Subtítulo Subtarefa" filled />
                    <q-input v-model="newSubtask.description" label="Descrição Subtarefa" filled />
                    <div class="q-mt-md" style="display: flex; justify-content: flex-end;">
                        <q-btn label="Adicionar Subtarefa" color="green" type="submit" />
                    </div>
                </q-form>
            </q-page-pading>
            
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
import { ref, onMounted, defineProps } from "vue";
import TaskService from "../services/TaskService";
import SubtaskService from "../services/SubtaskService";
import UserTaskAccessService from "../services/UserTaskAccessService";
import SubtaskItem from "../components/SubtaskItem.vue"

const props = defineProps({
    taskId: {
        type: Number,
        required: true,
    },
});

const showDialog = ref(false);
const dialogMessage = ref('');

const taskService = new TaskService();
const subtaskService = new SubtaskService();
const userTaskAccessService = new UserTaskAccessService();

const task = ref<any>({
    title: "",
    subtitle: "",
    description: "",
    due_date: "",
    subtasks: [],
});

const newSubtask = ref<any>({
    title: "",
    subtitle: "",
    description: "",
});

const userEmail = ref("");
const accessType = ref({ label: "Leitura (read)", value: "read" });

const loading = ref(true);

const accessTypes = [
    { label: "Leitura (read)", value: "read" },
    { label: "Escrita (write)", value: "write" }
];

const rules = {
    required: (val: string) => !!val || "Campo obrigatório",
    email: (val: string) =>
        /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(val) || "E-mail inválido",
};

const loadTaskDetails = async () => {
    try {
        const response = await taskService.getTaskDetails(props.taskId);
        task.value = response;
    } catch (error: any) {
        if (error?.response?.status === 403) {
            dialogMessage.value = "Você não tem permissão para acessar os detalhes dessa tarefa.";
        } else if (error?.response?.status === 404) {
            dialogMessage.value = "Tarefa não encontrada.";
        } else {
            dialogMessage.value = "Ocorreu um erro ao carregar os detalhes da tarefa.";
        }
        
        showDialog.value = true;
    } finally {
        loading.value = false;
    }
};

const handleStatusChanged = async () => {
    loadTaskDetails();
}

const handleSubtaskDeleted = async () => {
    loadTaskDetails();
}

const updateTask = async () => {
    try {
        const updatedTaskData = {
            title: task.value.title,
            subtitle: task.value.subtitle,
            description: task.value.description,
            due_date: task.value.due_date,
            subtasks: task.value.subtasks,
        };
    
        const response = await taskService.updateTask({task_id: props.taskId, ...updatedTaskData});
    } catch (error: any) {
        if (error?.response?.status === 403) {
            dialogMessage.value = "Você não tem permissão para atualizar os detalhes dessa tarefa.";
        } else if (error?.response?.status === 404) {
            dialogMessage.value = "Tarefa não encontrada para atualização.";
        } else {
            dialogMessage.value = "Ocorreu um erro ao tentar atualizar a tarefa.";
        }
        
        showDialog.value = true;
    }
};

const saveSubtask = async () => {
    try {
        const subtaskData = {
            title: newSubtask.value.title,
            subtitle: newSubtask.value.subtitle,
            description: newSubtask.value.description,
            task_id: props.taskId,
        };

        const response = await subtaskService.storeSubtask(subtaskData);

        task.value.subtasks.push(response);

        newSubtask.value.title = "";
        newSubtask.value.subtitle = "";
        newSubtask.value.description = "";
    } catch (error: any) {
        if (error?.response?.status === 403) {
            dialogMessage.value = "Você não tem permissão para adicionar uma subtarefa.";
        } else if (error?.response?.status === 404) {
            dialogMessage.value = "Tarefa não encontrada para adicionar a subtarefa.";
        } else {
            dialogMessage.value = "Ocorreu um erro ao tentar adicionar a subtarefa.";
        }
        
        showDialog.value = true;
    }
};

const inviteUser = async () => {
    try {
        if (!userEmail.value) {
            dialogMessage.value = "Por favor, preencha o email.";
            showDialog.value = true;
            return;
        }

        const response = await userTaskAccessService.store({
            task_id: props.taskId,
            user_email: userEmail.value,
            access_type: accessType.value.value,
        });

        dialogMessage.value = "Usuário convidado com sucesso!";
        showDialog.value = true;
        
        userEmail.value = "";
        accessType.value = { label: "Leitura (read)", value: "read" }
    } catch (error: any) {
        if (error?.response?.status === 403) {
            dialogMessage.value = "Você não tem permissão para convidar o usuário.";
        } else {
            dialogMessage.value = "Ocorreu um erro ao tentar convidar o usuário.";
        }
        
        showDialog.value = true;
    }
};

onMounted(() => {
    loadTaskDetails();
});
</script>

<style scoped>
.q-item {
    border-bottom: 1px solid #ddd;
}
</style>
