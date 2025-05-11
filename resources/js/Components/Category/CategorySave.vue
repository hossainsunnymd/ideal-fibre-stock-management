<script setup>
import { usePage, useForm } from "@inertiajs/vue3";
import { createToaster } from "@meforma/vue-toaster";
import { router } from "@inertiajs/vue3";

const toaster = createToaster({});
const page = usePage();
const category_id = new URLSearchParams(window.location.search).get(
    "category_id"
);
const category = page.props.category;

const form = useForm({
    category_id: category_id,
    category_name: "",
});
let URL = "/create-category";
if (category_id != 0 && category != null) {
    form.category_name = category.name;
    URL = "/update-category";
}

function submitForm() {
    form.post(URL, {
        preserveScroll: true,
        onSuccess: () => {
            if (page.props.flash.status == false) {
                toaster.error(page.props.flash.message);
            } else if (page.props.flash.status == true) {
                toaster.success(page.props.flash.message);
                router.visit("/list-category");
            }
        },
    });
}
</script>

<template>
    <div class="p-6 max-w-2xl w-full mx-auto">
        <h2 class="text-2xl font-semibold text-gray-800 mb-6 text-center">
            {{ category_id == 0 ? "Add Category" : "Update Category" }}
        </h2>

        <form @submit.prevent="submitForm" class="space-y-5">
            <div>
                <label
                    for="category_name"
                    class="block text-sm font-medium text-gray-700 mb-1"
                    >Category Name</label
                >
                <input
                    v-model="form.category_name"
                    type="text"
                    class="w-full px-4 py-2 border rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-400"
                />
                <p v-if="page.props.flash.errors" class="text-red-500">{{page.props.flash.errors.category_name[0] }}</p>
            </div>

            <div class="pt-3">
                <button
                    type="submit"
                    class="w-full bg-green-600 text-white py-2 rounded-xl hover:bg-green-700 transition duration-300"
                >
                    {{ category_id == 0 ? "Add Category" : "Update Category" }}
                </button>
            </div>
        </form>
    </div>
</template>

<style scoped></style>
