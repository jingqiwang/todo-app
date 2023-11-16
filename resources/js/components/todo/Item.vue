<template>
    <div>
        <div class="flex justify-between items-center">
            <div class="flex items-center">
                <input
                    name="is_completed"
                    type="checkbox"
                    :checked="item.is_completed"
                    @change="toggleCompletion"
                    class="h-4 w-4 text-teal-600 focus:ring-teal-500 border-gray-300 rounded"
                />
                <label for="todo1" class="ml-3 block text-gray-900">
                    <span class="text-lg font-medium">{{
                        item.description
                    }}</span>
                </label>
            </div>
            <button
                class="h-10 w-20 bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded border border-red-700"
                @click="deleteTodo"
            >
                Delete
            </button>
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    props: ["item"],
    data() {
        return {
            newTodo: "",
            items: [],
        };
    },
    methods: {
        toggleCompletion() {
            const updatedTodo = {
                is_completed: !this.item.is_completed,
            };

            axios
                .put("/api/todos/" + this.item.id, updatedTodo, {
                    withCredentials: true,
                })
                .then((response) => {
                    this.$emit("update-todo", response.data);
                })
                .catch((error) => {
                    console.error("Error updating todo:", error);
                    this.item.is_completed = !this.item.is_completed;
                });
        },
        deleteTodo() {
            if (confirm("Are you sure you want to delete this todo?")) {
                axios
                    .delete("/api/todos/" + this.item.id, {
                        withCredentials: true,
                    })
                    .then((response) => {
                        this.$emit("delete-todo", response);
                    })
                    .catch((error) => {
                        console.error("Error deleting todo:", error);
                    });
            }
        },
    },
};
</script>
