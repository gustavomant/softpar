<template>
    <q-item>
        <q-item-section :class="{'bg-grey-3': subtask.status === 'done'}">
            <q-item-label>{{ subtask.title }}</q-item-label>
            <q-item-label caption>{{ subtask.subtitle }}</q-item-label>
            <q-item-label>{{ subtask.description }}</q-item-label>

            <q-btn 
                flat 
                color="green" 
                icon="check" 
                @click="toggleStatus(subtask)" 
                class="q-mt-sm q-ml-sm" 
                label="Check" 
            />
            <q-btn 
                flat 
                color="negative" 
                icon="delete" 
                @click="deleteSubtask(subtask)" 
                class="q-mt-sm q-ml-sm" 
                label="Deletar" 
            />
        </q-item-section>
    </q-item>
</template>

<script>
import SubtaskService from "../services/SubtaskService";

export default {
    name: "SubtaskItem",
    props: {
        subtask: {
            type: Object,
            required: true
        }
    },
    data() {
        return {
            subtaskService: new SubtaskService()
        };
    },
    methods: {
        async toggleStatus(subtask) {
            try {
                const newStatus = subtask.status === "done" ? "pending" : "done";
                const subtaskData = { subtask_id: subtask.id, status: newStatus };
                const response = await this.subtaskService.updateSubtask(subtaskData);
                this.$emit('status-changed', response);
            } catch (error) {
                console.error("Erro ao alternar status da subtarefa", error);
            }
        },

        async deleteSubtask(subtask) {
            try {
                const subtaskData = { subtask_id: subtask.id, status: "removed" };
                const response = await this.subtaskService.updateSubtask(subtaskData);
                this.$emit('subtask-deleted', subtask.id);
            } catch (error) {
                console.error("Erro ao remover subtarefa", error);
            }
        }
    }
}
</script>
  