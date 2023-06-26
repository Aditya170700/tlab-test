<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";
import Pagination from "@/Components/Pagination.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import { reactive } from "vue";

defineProps({
    results: Object,
});

let property = reactive({
    isModalStore: false,
    isModalUpdate: false,
    isModalDestroy: false,
});

const storeForm = useForm({
    name: "",
});

function onToggleStore() {
    storeForm.name = "";
    property.isModalStore = !property.isModalStore;
}

const store = () => {
    storeForm.post(route("category.store"), {
        onSuccess: () => {
            onToggleStore();
        },
    });
};

const updateForm = useForm({
    id: "",
    name: "",
});

function onToggleUpdate(data = null) {
    updateForm.id = data?.id;
    updateForm.name = data?.name;
    property.isModalUpdate = !property.isModalUpdate;
}

const update = () => {
    updateForm.put(route("category.update", updateForm.id), {
        onSuccess: () => {
            onToggleUpdate();
        },
    });
};

const destroyForm = useForm({
    id: "",
});

function onToggleDestroy(data = null) {
    destroyForm.id = data?.id;
    property.isModalDestroy = !property.isModalDestroy;
}

const destroy = () => {
    destroyForm.delete(route("category.delete", destroyForm.id), {
        onSuccess: () => {
            onToggleDestroy();
        },
    });
};
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Dashboard" />

        <!-- STORE -->
        <transition name="fade">
            <div
                v-if="property.isModalStore"
                class="fixed flex justify-center align-middle z-10 inset-0 overflow-y-auto p-3"
            >
                <div
                    @click="onToggleStore"
                    class="fixed bg-black opacity-70 inset-0 z-1"
                ></div>
                <div
                    class="w-full max-w-lg p-3 relative mx-auto my-auto rounded-xl shadow-lg bg-white"
                >
                    <form @submit.prevent="store">
                        <div class="text-left p-3 leading-6">
                            <h2
                                class="font-semibold text-xl text-gray-800 leading-tight mb-5"
                            >
                                Store Category
                            </h2>
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
                        </div>
                        <div class="p-3 space-x-4 md:block">
                            <button
                                :class="`mb-2 md:mb-0 bg-gray-800 border border-gray-800 px-5 py-2 text-sm shadow-sm font-medium tracking-wider text-white rounded-md hover:shadow-lg hover:bg-gray-700 ${
                                    storeForm.processing ? 'opacity-25' : ''
                                }`"
                                :disabled="storeForm.processing"
                                type="submit"
                            >
                                Save
                            </button>
                            <button
                                @click="onToggleStore"
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

        <!-- UPDATE -->
        <transition name="fade">
            <div
                v-if="property.isModalUpdate"
                class="fixed flex justify-center align-middle z-10 inset-0 overflow-y-auto p-3"
            >
                <div
                    @click="onToggleUpdate"
                    class="fixed bg-black opacity-70 inset-0 z-1"
                ></div>
                <div
                    class="w-full max-w-lg p-3 relative mx-auto my-auto rounded-xl shadow-lg bg-white"
                >
                    <form @submit.prevent="update">
                        <div class="text-left p-3 leading-6">
                            <h2
                                class="font-semibold text-xl text-gray-800 leading-tight mb-5"
                            >
                                Update Category
                            </h2>
                            <div class="mb-3">
                                <InputLabel for="name" value="Name" />

                                <TextInput
                                    id="name"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="updateForm.name"
                                />

                                <InputError
                                    class="mt-2"
                                    :message="updateForm.errors.name"
                                />
                            </div>
                        </div>
                        <div class="p-3 space-x-4 md:block">
                            <button
                                :class="`mb-2 md:mb-0 bg-gray-800 border border-gray-800 px-5 py-2 text-sm shadow-sm font-medium tracking-wider text-white rounded-md hover:shadow-lg hover:bg-gray-700 ${
                                    updateForm.processing ? 'opacity-25' : ''
                                }`"
                                :disabled="updateForm.processing"
                                type="submit"
                            >
                                Save
                            </button>
                            <button
                                @click="onToggleUpdate"
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

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-5">
                            <h2
                                class="font-semibold text-xl text-gray-800 leading-tight"
                            >
                                Category
                            </h2>
                            <button
                                class="px-6 py-1 rounded-md bg-gray-800 hover:bg-gray-700 text-white"
                                @click="onToggleStore"
                            >
                                Add
                            </button>
                        </div>
                        <table class="table-auto w-full">
                            <thead>
                                <tr class="border">
                                    <th class="border px-4 py-2 w-20">No.</th>
                                    <th class="border px-4 py-2 text-left">
                                        Name
                                    </th>
                                    <th class="border px-4 py-2 w-60"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="(result, i) in results.data"
                                    :key="i"
                                >
                                    <td class="border px-4 py-2 text-center">
                                        {{ i + 1 }}
                                    </td>
                                    <td class="border px-4 py-2">
                                        {{ result.name }}
                                    </td>
                                    <td class="border px-4 py-2">
                                        <div
                                            class="d-flex justify-center text-center"
                                        >
                                            <button
                                                type="button"
                                                class="px-6 py-1 rounded-md bg-orange-600 hover:bg-orange-500 text-white mr-1"
                                                @click="onToggleUpdate(result)"
                                            >
                                                Edit
                                            </button>
                                            <button
                                                type="button"
                                                class="px-6 py-1 rounded-md bg-red-600 hover:bg-red-500 text-white"
                                                @click="onToggleDestroy(result)"
                                            >
                                                Delete
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr v-if="results.data.length == 0">
                                    <td
                                        class="border py-2 text-center"
                                        colspan="3"
                                    >
                                        Data not found
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <Pagination class="mt-6" :links="results.links" />
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
