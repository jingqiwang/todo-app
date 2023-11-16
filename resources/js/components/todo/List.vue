<template>
    <div>
        <div
            class="max-w-md mx-auto bg-white shadow-lg rounded-lg overflow-hidden mt-16"
        >
            <div class="px-4 py-2">
                <h1 class="text-gray-800 font-bold text-2xl uppercase">
                    To-Do List
                </h1>
            </div>

            <!-- Alert messages -->
            <div v-if="alertMessage.text" :class="alertClass">
                {{ alertMessage.text }}
            </div>

            <!-- Add new todo -->
            <div
                class="w-full py-2 px-4 my-0 flex items-center justify-between"
            >
                <input
                    class="shadow appearance-none border rounded w-full py-2 px-3 mr-4 text-grey-darker"
                    placeholder="Add Todo"
                    v-model="newTodo"
                />
                <button
                    class="h-10 w-20 flex-shrink-0 bg-teal-500 hover:bg-teal-700 border-teal-500 hover:border-teal-700 text-sm border-4 text-white py-1 px-2 rounded"
                    type="button"
                    @click="addTodo"
                >
                    Add
                </button>
            </div>

            <!-- Todo list items -->
            <div class="mb-10">
                <ul class="divide-y divide-gray-200 px-4">
                    <li class="py-4" v-for="item in items" :key="item.id">
                        <Item
                            :item="item"
                            @update-todo="handleUpdateTodo"
                            @delete-todo="handleDeleteTodo"
                        />
                    </li>
                </ul>
            </div>
        </div>

        <!-- Pagination -->
        <div class="mt-10 text-center">
            <nav aria-label="Page navigation example">
                <ul class="inline-flex -space-x-px">
                    <li v-for="link in pagination.links" :key="link.label">
                        <a
                            v-if="link.url"
                            @click.prevent="fetchTodos(link.url)"
                            :class="{ 'bg-blue-50': link.active }"
                            class="bg-white border border-gray-300 text-gray-500 hover:bg-gray-100 hover:text-gray-700 leading-tight py-2 px-3 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
                        >
                            <span v-html="link.label"></span>
                        </a>
                        <span
                            v-else
                            class="bg-white border border-gray-300 text-gray-500 leading-tight py-2 px-3 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400"
                        >
                            <span v-html="link.label"></span>
                        </span>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import Item from "./Item.vue";

export default {
    components: {
        Item,
    },
    data() {
        return {
            newTodo: "",
            items: [],
            alertMessage: {},
            pagination: {
                current_page: 1,
                last_page: 1,
                links: [],
            },
        };
    },
    methods: {
        addTodo() {
            if (!this.newTodo.trim()) {
                this.setAlertMessage("Task can not be empty", "error");
                return;
            }

            const newTodoItem = {
                description: this.newTodo,
                is_completed: false,
            };

            axios
                .post("/api/todos", newTodoItem, {
                    withCredentials: true,
                })
                .then((response) => {
                    this.items = response.data.data;
                    this.pagination = response.data;
                    this.newTodo = "";
                    this.setAlertMessage("Add new task success", "success");
                })
                .catch((error) => {
                    console.error("Error adding todo:", error);
                });
        },
        fetchTodos(url) {
            axios
                .get(url, { withCredentials: true })
                .then((response) => {
                    this.items = response.data.data;
                    this.pagination = response.data;
                })
                .catch((error) => {
                    console.error("Error fetching todos:", error);
                });
        },
        handleUpdateTodo(updatedItem) {
            const index = this.items.findIndex(
                (item) => item.id === updatedItem.id
            );
            if (index !== -1) {
                this.items.splice(index, 1, updatedItem);
            }
            this.setAlertMessage("Update task success", "success");
        },
        handleDeleteTodo(response) {
            this.items = response.data.data;
            this.pagination = response.data;
            this.setAlertMessage("Delete task success", "success");
        },
        setAlertMessage(text, type) {
            this.alertMessage = { text, type };
        },
    },
    computed: {
        alertClass() {
            return {
                "flex p-4 mb-4 m-4 text-sm rounded-lg": true,
                "bg-red-100 text-red-700": this.alertMessage.type === "error",
                "bg-green-100 text-green-700": this.alertMessage.type === "success",
            };
        },
    },
    beforeCreated() {
        // Get access token
        axios.get("/sanctum/csrf-cookie").then((response) => {
            // token already saved in cookie
        });
    },
    created() {
        this.fetchTodos("/api/todos?page=1");
    },
};
</script>
