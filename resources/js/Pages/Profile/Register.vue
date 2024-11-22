<script setup>
import { Head, Link, useForm, usePage, router } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import Dropdown from '@/Components/Dropdown.vue';
import { ref, computed } from 'vue';

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const authUserId = computed(() => usePage().props.auth.user.id);

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    type: '',
    phone: '',
    dob: '',
    address: '',
    profile: '',
    create_user_id: authUserId.value,
    updated_user_id: authUserId.value,
});

const previewImage = ref(null);
const currentImage = ref(null);

const handleImageChange = (event) => {
  const allowedFileTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/bmp', 'image/webp', 'image/tiff', 'image/tif'];
  const maxFileSize = 1 * 1048576; // 1 MB
  const file = event.target.files[0];

  if (file) {
    const fileType = file.type;
    const fileSize = file.size;

    if (!allowedFileTypes.includes(fileType)) {
      alert("Invalid file type. Please upload an image");
      return;
    }

    if (fileSize > maxFileSize) {
      alert("Image size is too big. Please upload a smaller size");
      return;
    }

    form.profile = file;
    const reader = new FileReader();
    reader.onload = (e) => {
      previewImage.value = e.target.result;
    };
    reader.readAsDataURL(file);
  } else {
    previewImage.value = null;
  }
};

const submitForm = () => {
    form.post(route('profile.register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};

const navigateDashboard = () => {
    router.get('dashboard');
}

</script>

<template>

    <Head title="Register Profile" />

    <AuthenticatedLayout>
        <div class="py-12">
            <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
                <div class="bg-white p-4 shadow sm:rounded-lg sm:p-8">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">
                                Register
                            </h2>
                        </header>

                        <form @submit.prevent="submitForm" class="mt-6 space-y-6">
                            <div>
                                <InputLabel for="name" value="Name" />

                                <TextInput id="name" type="text" class="mt-1 block w-full" v-model="form.name" required
                                    autofocus autocomplete="name" />

                                <InputError class="mt-2" :message="form.errors.name" />
                            </div>
                            <div>
                                <InputLabel for="email" value="Email" />

                                <TextInput id="email" type="email" class="mt-1 block w-full" v-model="form.email"
                                    required autocomplete="username" />

                                <InputError class="mt-2" :message="form.errors.email" />
                            </div>

                            <div>
                                <InputLabel for="password" value="Password" />

                                <TextInput id="password" type="password" class="mt-1 block w-full"
                                    v-model="form.password" required autocomplete="new-password" />

                                <InputError class="mt-2" :message="form.errors.password" />
                            </div>

                            <div>
                                <InputLabel for="password_confirmation" value="Confirm Password" />

                                <TextInput id="password_confirmation" type="password" class="mt-1 block w-full"
                                    v-model="form.password_confirmation" required autocomplete="new-password" />

                                <InputError class="mt-2" :message="form.errors.password_confirmation" />
                            </div>

                            <div>
                                <InputLabel for="type" value="Type" />
                                <select v-model="form.type" id="type"
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    <option value="0">Admin</option>
                                    <option value="1">User</option>
                                </select>
                            </div>

                            <div>
                                <InputLabel for="phone" value="Phone" />

                                <TextInput id="phone" type="text" class="mt-1 block w-full" v-model="form.phone"/>

                                <InputError class="mt-2" :message="form.errors.phone" />
                            </div>

                            <div>
                                <InputLabel for="dob" value="Date of Birth" />

                                <TextInput id="dob" type="date" class="mt-1 block w-full" v-model="form.dob" autocomplete="dob" />

                                <InputError class="mt-2" :message="form.errors.dob" />
                            </div>

                            <div>
                                <InputLabel for="address" value="Address" />

                                <TextInput id="address" type="text" class="mt-1 block w-full" v-model="form.address" autocomplete="address" />

                                <InputError class="mt-2" :message="form.errors.address" />
                            </div>

                            <InputLabel for="profile_image" value="Upload Profile Image" />
                            <div class="max-w-md mx-auto p-6 bg-white shadow-md rounded-md">
                                <div class="mb-4">
                                    <img v-if="previewImage" :src="previewImage" alt="Profile Image"
                                        class="w-32 h-32 rounded-full mx-auto mb-4" />
                                    <img v-else
                                        :src="(currentImage && currentImage != 'profile.svg') ? 'storage/profile_images/' + currentImage : '/images/profile.svg'"
                                        alt="Profile Image" class="w-32 h-32 rounded-full mx-auto mb-4" />
                                    <label for="profile_image">
                                        <span class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">
                                            Choose Image
                                        </span>
                                    </label>
                                    <input id="profile_image" type="file"
                                        accept=".jpg, .jpeg, .png, .gif, .bmp, .webp, .tiff, .tif" ref="fileInput"
                                        @change="handleImageChange" class="hidden" />
                                </div>
                            </div>

                            <div class="flex items-center gap-4">
                                <div class="flex space-x-4">
                                    <button @click.prevent="submitForm"  class="inline-flex items-center rounded-md border border-transparent bg-blue-800 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition duration-150 ease-in-out hover:bg-blue-600 focus:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 active:bg-gray-900">
                                        Register
                                    </button>
                                    <button @click.prevent="navigateDashboard" class="inline-flex items-center rounded-md border border-transparent bg-gray-400 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition duration-150 ease-in-out hover:bg-gray-700 focus:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 active:bg-gray-900">
                                        Cancel
                                    </button>
                                </div>
                            </div>
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>

</template>