<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";
import Pagination from "@/Components/Pagination.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import { reactive } from "vue";

defineProps({
    results: Object,
    categories: Array,
    ingredients: Array,
});

let params = route().params;

let property = reactive({
    isModalDestroy: false,
    isModalFilter: false,
});

const destroyForm = useForm({
    id: "",
});

function onToggleDestroy(data = null) {
    destroyForm.id = data?.id;
    property.isModalDestroy = !property.isModalDestroy;
}

const destroy = () => {
    destroyForm.delete(route("recipe.delete", destroyForm.id), {
        onSuccess: () => {
            onToggleDestroy();
        },
    });
};

const filterForm = useForm({
    name: params.name ?? "",
    categories: params.categories ?? [],
    ingredients: params.ingredients ?? [],
});

function onToggleFilter() {
    property.isModalFilter = !property.isModalFilter;
}

const filter = () => {
    filterForm.get(route("recipe.index"), {
        onSuccess: () => {
            onToggleFilter();
        },
    });
};

const resetFilterForm = () => {
    filterForm.name = "";
    filterForm.categories = [];
    filterForm.ingredients = [];
};
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Dashboard" />

        <!-- DESTROY -->
        <transition name="fade">
            <div
                v-if="property.isModalDestroy"
                class="fixed flex justify-center align-middle z-10 inset-0 overflow-y-auto p-3"
            >
                <div
                    @click="onToggleDestroy"
                    class="fixed bg-black opacity-70 inset-0 z-1"
                ></div>
                <div
                    class="w-full max-w-lg p-3 relative mx-auto my-auto rounded-xl shadow-lg bg-white"
                >
                    <form @submit.prevent="destroy">
                        <div
                            class="text-center p-3 flex-auto justify-center leading-6"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="w-16 h-16 flex items-center text-red-600 mx-auto"
                                viewBox="0 0 20 20"
                                fill="currentColor"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                    clip-rule="evenodd"
                                />
                            </svg>
                            <h2 class="text-2xl text-red-600 font-bold py-4">
                                Are you sure?
                            </h2>
                            <p class="text-md text-red-500 px-8">
                                Do you really want to destroy this data?
                            </p>
                        </div>
                        <div class="p-3 text-center space-x-4 md:block">
                            <button
                                :class="`mb-2 md:mb-0 bg-red-600 border border-red-600 px-5 py-2 text-sm shadow-sm font-medium tracking-wider text-white rounded-md hover:shadow-lg hover:bg-red-500 ${
                                    destroyForm.processing ? 'opacity-25' : ''
                                }`"
                                :disabled="destroyForm.processing"
                                type="submit"
                            >
                                Save
                            </button>
                            <button
                                @click="onToggleDestroy"
                                type="button"
                                class="mb-2 md:mb-0 bg-white px-5 py-2 text-sm shadow-sm font-medium tracking-wider border text-gray-600 rounded-md hover:shadow-lg hover:bg-gray-100"
                            >
                                Close
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </transition>

        <!-- FILTER -->
        <transition name="fade">
            <div
                v-if="property.isModalFilter"
                class="fixed flex justify-center align-middle z-10 inset-0 overflow-y-auto p-3"
            >
                <div
                    @click="onToggleFilter"
                    class="fixed bg-black opacity-70 inset-0 z-1"
                ></div>
                <div
                    class="w-full max-w-lg p-3 relative mx-auto my-auto rounded-xl shadow-lg bg-white"
                >
                    <form @submit.prevent="filter">
                        <div class="text-left p-3 leading-6">
                            <div class="flex justify-between">
                                <h2
                                    class="font-semibold text-xl text-gray-800 leading-tight mb-5"
                                >
                                    Filter
                                </h2>
                                <div
                                    class="text-red-800 hover:text-red-700 font-bold"
                                    @click="onToggleFilter"
                                >
                                    Close
                                </div>
                            </div>
                            <div class="mb-3">
                                <InputLabel for="name" value="Name" />

                                <TextInput
                                    id="name"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="filterForm.name"
                                />
                            </div>
                            <div
                                class="grid lg:grid-cols-2 lg:gap-3 sm:grid-cols-1"
                            >
                                <div class="mb-3">
                                    <InputLabel class="mb-2" value="Category" />
                                    <div
                                        class="flex items-center mb-2"
                                        v-for="(cat, i) in categories"
                                        :key="i"
                                    >
                                        <input
                                            type="checkbox"
                                            class="rounded text-gray-800 mr-2"
                                            v-model="filterForm.categories"
                                            :value="cat.id"
                                            :id="`cat-${cat.id}`"
                                        />
                                        <label
                                            :for="`cat-${cat.id}`"
                                            class="text-sm"
                                        >
                                            {{ cat.name }}
                                        </label>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <InputLabel
                                        class="mb-2"
                                        value="Ingredient"
                                    />
                                    <div
                                        class="flex items-center mb-2"
                                        v-for="(ing, i) in ingredients"
                                        :key="i"
                                    >
                                        <input
                                            type="checkbox"
                                            class="rounded text-gray-800 mr-2"
                                            v-model="filterForm.ingredients"
                                            :value="ing.id"
                                            :id="`ing-${ing.id}`"
                                        />
                                        <label
                                            :for="`ing-${ing.id}`"
                                            class="text-sm"
                                        >
                                            {{ ing.name }}
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="p-3 space-x-4 md:block">
                            <button
                                :class="`mb-2 md:mb-0 bg-gray-800 hover:bg-gray-700 border px-5 py-2 text-sm shadow-sm font-medium tracking-wider text-white rounded-md hover:shadow-lg  ${
                                    filterForm.processing ? 'opacity-25' : ''
                                }`"
                                :disabled="filterForm.processing"
                                type="submit"
                            >
                                Filter
                            </button>
                            <button
                                type="button"
                                class="mb-2 md:mb-0 bg-white px-5 py-2 text-sm shadow-sm font-medium tracking-wider border text-gray-600 rounded-md hover:shadow-lg hover:bg-gray-100"
                                @click="resetFilterForm"
                            >
                                Reset
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </transition>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-5">
                            <h2
                                class="font-semibold text-xl text-gray-800 leading-tight"
                            >
                                Recipe
                            </h2>
                            <div>
                                <a
                                    class="px-6 py-1 rounded-md bg-white hover:bg-gray-800 text-gray-800 hover:text-white mr-1 border"
                                    href="#"
                                    @click="onToggleFilter"
                                >
                                    Filter
                                </a>
                                <Link
                                    :href="route('recipe.create')"
                                    class="px-6 py-1 rounded-md bg-gray-800 hover:bg-gray-700 text-white"
                                >
                                    Add
                                </Link>
                            </div>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead>
                                    <tr class="border">
                                        <th class="border px-4 py-2 w-20">
                                            No.
                                        </th>
                                        <th class="border px-4 py-2 text-left">
                                            Name
                                        </th>
                                        <th class="border px-4 py-2 text-left">
                                            Category
                                        </th>
                                        <th class="border px-4 py-2 text-left">
                                            Ingredients
                                        </th>
                                        <th class="border px-4 py-2 w-60"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        v-for="(result, i) in results.data"
                                        :key="i"
                                    >
                                        <td
                                            class="border px-4 py-2 text-center"
                                        >
                                            {{ i + 1 }}
                                        </td>
                                        <td class="border px-4 py-2">
                                            {{ result.name }}
                                        </td>
                                        <td class="border px-4 py-2">
                                            {{ result.category.name }}
                                        </td>
                                        <td class="border px-4 py-2 text-sm">
                                            <div
                                                v-for="(
                                                    ing, i
                                                ) in result.ingredients"
                                                :key="i"
                                                class="mb-1"
                                            >
                                                - {{ ing.name }} ({{
                                                    ing.pivot.amount
                                                }})
                                            </div>
                                        </td>
                                        <td class="border px-4 py-2">
                                            <div
                                                class="d-flex justify-center text-center"
                                            >
                                                <Link
                                                    :href="
                                                        route(
                                                            'recipe.edit',
                                                            result.id
                                                        )
                                                    "
                                                    class="px-6 py-1 rounded-md bg-orange-600 hover:bg-orange-500 text-white mr-1"
                                                >
                                                    Edit
                                                </Link>
                                                <a
                                                    href="#"
                                                    class="px-6 py-1 rounded-md bg-red-600 hover:bg-red-500 text-white"
                                                    @click="
                                                        onToggleDestroy(result)
                                                    "
                                                >
                                                    Delete
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr v-if="results.data.length == 0">
                                        <td
                                            class="border py-2 text-center"
                                            colspan="5"
                                        >
                                            Data not found
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <Pagination class="mt-6" :links="results.links" />
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
