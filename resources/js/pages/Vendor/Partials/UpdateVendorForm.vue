<script setup>
import { Link, useForm, usePage } from '@inertiajs/vue3';
import { ref } from 'vue';
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
console.log(vendor)

const form = useForm({
    name: vendor && vendor.name ? vendor.name : '',
    email: vendor && vendor.email ? vendor.email : '',
    mobile: vendor && vendor.mobile ? vendor.mobile : '',
    address: vendor && vendor.address ? vendor.address : '',
});

const handleSubmit = (e)=>{
    e.preventDefault()

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
                <InputLabel for="mobile" value="Mobile" />

                <TextInput id="mobile" type="text" class="mt-1 block w-full" v-model="form.mobile" required autofocus
                    autocomplete="mobile" />

                <InputError class="mt-2" :message="form.errors.mobile" />
            </div>

            <div>
                <InputLabel for="address" value="Address" />

                <TextInput id="address" type="address" class="mt-1 block w-full" v-model="form.address" required
                    autocomplete="address" />

                <InputError class="mt-2" :message="form.errors.address" />
            </div>
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
