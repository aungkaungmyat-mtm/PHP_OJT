<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Link, useForm, usePage } from '@inertiajs/vue3';
import { ref } from 'vue';

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const user = usePage().props.auth.user;
const currentImage = ref(user.profile);
const previewImage = ref(null);

const form = useForm({
    name: user.name,
    email: user.email,
    profile: null,
    old_image: currentImage.value,
});

const handleFileChange = (event) => {
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

    form.post(route('profile.update'), {
        forceFormData: true, 
        onSuccess: () => {
            console.log('Profile updated successfully');
        },
        onError: (errors) => {
            console.error('Error updating profile', errors);
        }
    });
};

</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900">
                Profile Information
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                Update your account's profile information and email address.
            </p>
        </header>

        <form
            @submit.prevent="submitForm"
            class="mt-6 space-y-6"
        >
            <div>
                <InputLabel for="name" value="Name" />

                <TextInput
                    id="name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.name"
                    required
                    autofocus
                    autocomplete="name"
                />

                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <div>
                <InputLabel for="email" value="Email" />

                <TextInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full"
                    v-model="form.email"
                    required
                    autocomplete="username"
                />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div v-if="mustVerifyEmail && user.email_verified_at === null">
                <p class="mt-2 text-sm text-gray-800">
                    Your email address is unverified.
                    <Link
                        :href="route('verification.send')"
                        method="post"
                        as="button"
                        class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                    >
                        Click here to re-send the verification email.
                    </Link>
                </p>

                <div
                    v-show="status === 'verification-link-sent'"
                    class="mt-2 text-sm font-medium text-green-600"
                >
                    A new verification link has been sent to your email address.
                </div>
            </div>

            <h4 class="text-md mb-4">Update Profile Image</h4>
            <div class="max-w-md mx-auto p-6 bg-white shadow-md rounded-md">
                <div class="mb-4">
                    <img v-if="previewImage && currentImage" :src="previewImage" alt="Profile Image"
                        class="w-32 h-32 rounded-full mx-auto mb-4" />
                    <img v-else :src="currentImage && currentImage !='profile.svg' ? 'storage/profile_images/' + currentImage : '/images/profile.svg'" alt="Profile Image"
                        class="w-32 h-32 rounded-full mx-auto mb-4" />
                    <label for="profile_image">
                        <span class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">
                            Choose Image
                        </span>
                    </label>
                    <input id="profile_image" type="file" accept=".jpg, .jpeg, .png, .gif, .bmp, .webp, .tiff, .tif" ref="fileInput" @change="handleFileChange" class="hidden" />
                </div>
            </div>

            <div class="flex items-center gap-4">
                <PrimaryButton :disabled="form.processing">Save</PrimaryButton>

                <Transition
                    enter-active-class="transition ease-in-out"
                    enter-from-class="opacity-0"
                    leave-active-class="transition ease-in-out"
                    leave-to-class="opacity-0"
                >
                    <p
                        v-if="form.recentlySuccessful"
                        class="text-sm text-gray-600"
                    >
                        Saved.
                    </p>
                </Transition>
            </div>
        </form>
    </section>
</template>
