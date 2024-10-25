<script setup>
import { ref } from "vue";
import { usePage, router } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

import { Head } from "@inertiajs/vue3";
import { Heart, Star } from "lucide-vue-next";

const { feedbacks, query } = usePage().props;

console.log(feedbacks);

const searchQuery = ref(query || "");
const isLiking = ref(false);

function formatDate(dateString) {
    const date = new Date(dateString);
    const options = {
        year: "numeric",
        month: "long",
        day: "numeric",
        timeZone: "UTC",
    };
    return date.toLocaleString("pt-BR", options);
}

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
        <form @submit.prevent="search">
            <input v-model="searchQuery" type="text" />
        </form>
        <nav>
            <div v-for="feedback in feedbacks">
                <div>
                    <img :src="feedback.profile" alt="" />
                    <div>
                        <h4>
                            {{ feedback.user_name }}
                        </h4>
                        <small>{{ formatDate(feedback.created_at) }}</small>
                    </div>
                </div>
                <strong>{{ feedback.place }}</strong>
                <div class="rating">
                    <Star v-for="star in feedback.rating" :key="star" />
                </div>
                <span>{{ feedback.categorie }}</span>
                <img :src="feedback.image" alt="" />
                <p>{{ feedback.comment }}</p>
                <div>
                    <button @click="like(feedback.id)" :disabled="isLiking">
                        <Heart :class="{ liked: feedback.has_liked }" />
                        {{ feedback.likes_count }}
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
            /* align-items: center; */
            gap: 10px;
            padding-bottom: 10px;
            border-bottom: 1px solid #ccc;

            img {
                height: 40px;
                width: 40px;
                border-radius: 50%;
            }
        }

        > div:nth-child(3) {
            display: flex;
            margin: 4px 0;
        }

        > div:last-child {
            display: flex;
            justify-content: space-between;
            margin-top: 1rem;

            button {
                svg.liked {
                    color: red;
                    fill: red;
                }
            }
        }
    }
}
</style>
