<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";
import Pagination from "@/Components/Pagination.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import { reactive } from "vue";

defineProps({
    categories: Array,
    ingredients: Array,
});

const storeForm = useForm({
    name: "",
    category_id: "",
    ingredients: [],
});

const submit = () => {
    storeForm.post(route("recipe.store"));
};

const addIngredient = () => {
    storeForm.ingredients.push({
        id: "",
        amount: "",
    });
};
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Dashboard" />

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-5">
                            <h2
                                class="font-semibold text-xl text-gray-800 leading-tight"
                            >
                                Add Recipe
                            </h2>
                            <Link
                                :href="route('recipe.index')"
                                class="px-6 py-1 rounded-md bg-gray-800 hover:bg-gray-700 text-white"
                            >
                                Back
                            </Link>
                        </div>
                        <div class="grid lg:grid-cols-2 lg:gap-6">
                            <div class="mb-3">
                                <InputLabel for="name" value="Name" />

                                <TextInput
                                    id="name"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="storeForm.name"
                                />

                                <InputError
                                    class="mt-2"
                                    :message="storeForm.errors.name"
                                />
                            </div>
                            <div class="mb-3">
                                <InputLabel
                                    for="category_id"
                                    value="Category"
                                />

                                <select
                                    name="category_id"
                                    id="category_id"
                                    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full"
                                    v-model="storeForm.category_id"
                                >
                                    <option value="">Choose</option>
                                    <option
                                        :value="cat.id"
                                        v-for="(cat, i) in categories"
                                        :key="i"
                                    >
                                        {{ cat.name }}
                                    </option>
                                </select>

                                <InputError
                                    class="mt-2"
                                    :message="storeForm.errors.category_id"
                                />
                            </div>
                        </div>
                        <div class="grid lg:grid-cols-1 font-bold mb-3">
                            Ingredients
                        </div>
                        <div
                            class="mb-3"
                            v-for="(ingredient, i) in storeForm.ingredients"
                            :key="i"
                        >
                            <div class="grid grid-cols-2">
                                <InputLabel
                                    :for="`id-${i}`"
                                    value="Ingredient"
                                    class="inline"
                                />
                                <div class="text-right">
                                    <span
                                        class="text-sm text-red-800 hover:text-red-700 hover:cursor-pointer"
                                        >Remove Ingredient</span
                                    >
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-6">
                                <div class="mb-3">
                                    <select
                                        :id="`id-${i}`"
                                        class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full"
                                        v-model="ingredient.id"
                                    >
                                        <option value="">
                                            Choose Ingredient
                                        </option>
                                        <option
                                            :value="ing.id"
                                            v-for="(ing, i) in ingredients"
                                            :key="i"
                                        >
                                            {{ ing.name }}
                                        </option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <TextInput
                                        type="text"
                                        class="mt-1 block w-full"
                                        v-model="ingredient.amount"
                                        placeholder="Amount"
                                    />
                                </div>
                            </div>
                        </div>
                        <div class="d-flex mt-3">
                            <button
                                class="rounded-md bg-red-800 hover:bg-red-700 text-white px-3 py-1 mr-1"
                                @click="addIngredient"
                            >
                                Add Ingredient
                            </button>
                            <button
                                class="rounded-md bg-gray-800 hover:bg-gray-700 text-white px-3 py-1"
                                @click="submit"
                            >
                                Save
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
