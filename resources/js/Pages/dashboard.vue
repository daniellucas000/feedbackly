<script setup>
import { ref } from "vue";
import { usePage, router } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

import { Head } from "@inertiajs/vue3";

const { feedbacks, query } = usePage().props;

const searchQuery = ref(query || "");
const isLiking = ref(false);

function search() {
    let params = {};

    if (searchQuery.value) {
        params.q = searchQuery.value;
    }

    router.get(
        route("dashboard"),
        params,
        { replace: true },
        {
            onFinish: () => {
                console.log("oi");
            },
        }
    );
}

function like(id) {
    isLiking.value = true;
    router.post(
        route("feedbacks.likes", { id: id }),
        {},
        {
            onFinish: () => {
                console.log("oi");
            },
        }
    );
}
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>
        <form @submit.prevent="search">
            <input v-model="searchQuery" type="text" />
        </form>
        <nav>
            <div v-for="feedback in feedbacks">
                <div>
                    <img :src="feedback.profile" alt="" />
                    <h4>
                        {{ feedback.user_name }}
                    </h4>
                </div>
                <div class="rating">
                    <span
                        class="star"
                        v-for="star in feedback.rating"
                        :key="star"
                    >
                        ⭐
                    </span>
                </div>
                <p>{{ feedback.comment }}</p>
                <img :src="feedback.image" alt="" />
                <div>
                    <span>{{ feedback.categorie }}</span>
                    <button @click="like(feedback.id)" :disabled="isLiking">
                        👍
                    </button>
                    <span>{{ feedback.city }}</span>
                </div>
            </div>
        </nav>
    </AuthenticatedLayout>
</template>

<style lang="scss" scoped>
nav {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1rem;

    > div {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        border: 1px solid #ccc;
        border-radius: 15px;
        padding: 1rem;

        > div:nth-child(1) {
            display: flex;
            align-items: center;
            gap: 10px;
            padding-bottom: 10px;
            border-bottom: 1px solid #ccc;

            img {
                height: 40px;
                width: 40px;
                border-radius: 50%;
            }
        }

        div:last-child {
            display: flex;
            justify-content: space-between;
            margin-top: 1rem;
        }
    }
}
</style>
