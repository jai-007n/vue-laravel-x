<script setup>
import { Link, useForm, usePage } from '@inertiajs/vue3';
import { ref, computed, watch } from 'vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';


const props = defineProps({
    vendor: {
        required: true
    }
});
const vendor = props.vendor

const form = useForm({
    name: vendor && vendor.name ? vendor.name : '',
    email: vendor && vendor.email ? vendor.email : '',
    mobile: vendor && vendor.mobile ? vendor.mobile : '',
    address: vendor && vendor.address ? vendor.address : '',
});

// watch(form.mobile, (val, oldVal) => {
//     // isChnaing = form.mobile === document.activeElement
//     console.log('Saving mobile chnage...', val);
//     console.log('Saving mobile chnage...', oldVal);
// });
// watch(
//     form,
//     (newForm) => {
//         console.log('Mobile changed:', newForm.mobile);
//     },
//     { deep: true } // 🔑 needed for nested properties
// );

// watch(
//     () => form.mobile, // getter function
//     (newMobile, oldVal) => {
//         triggerCompute.value = true;
//         console.log('Mobile changed:', newMobile); // ✅ newMobile is form.mobile
//         console.log('Saving mobile chnage...', oldVal);
//         console.log('trigger compute calue...', triggerCompute);
//     }
// );
const isCorrectMobile = ref(false);
// const isCorrectMobile = computed(() => {
//     console.log(triggerCompute.value,triggerCompute)
//     return triggerCompute.value && form.mobile.length >= 10;
// });

const handleSubmit = (e) => {
    e.preventDefault()
    if (form.mobile.length < 10) {
        isCorrectMobile.value = true;
        return
    }
    if (!vendor) {
        form.post(route('vendor.store'))
    } else {
        form.put(route('vendor.update', vendor.id))
    }
}


</script>
<template>
    <section>
        <header>
            <div class="flex justify-between items-center">
                <h2 class="text-lg font-medium text-gray-900">
                    {{ vendor ? 'Edit' : 'Add' }} Vendor
                </h2>

                <Link :href="route('vendor.list')"
                    class='bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded'>Back</Link>
            </div>
        </header>

        <form @submit.prevent="handleSubmit" class="mt-6 space-y-6">

            <div>
                <InputLabel for="name" value="Name" />

                <TextInput id="name" type="text" class="mt-1 block w-full" v-model="form.name" required autofocus
                    autocomplete="name" />

                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <div>
                <InputLabel for="email" value="Email" />

                <TextInput id="email" type="email" class="mt-1 block w-full" v-model="form.email" required
                    autocomplete="username" />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>
            <div>
                <InputLabel for="mobile" value="Mobile" />

                <TextInput id="mobile" type="text" class="mt-1 block w-full" v-model="form.mobile" required autofocus
                    autocomplete="mobile" />

                <InputError class="mt-2" :message="form.errors.mobile" />
                <InputError v-if="isCorrectMobile" class="mt-2" :message="'Mobile length should be at least 10 char'" />
            </div>

            <div>
                <InputLabel for="address" value="Address" />

                <TextInput id="address" type="text" class="mt-1 block w-full" v-model="form.address" required
                    autocomplete="address" />

                <InputError class="mt-2" :message="form.errors.address" />
            </div>



            <div class="flex items-center gap-4">
                <PrimaryButton :disabled="form.processing">Save</PrimaryButton>

                <Transition enter-active-class="transition ease-in-out" enter-from-class="opacity-0"
                    leave-active-class="transition ease-in-out" leave-to-class="opacity-0">
                    <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">
                        Saved.
                    </p>
                </Transition>
            </div>
        </form>
    </section>
</template>
