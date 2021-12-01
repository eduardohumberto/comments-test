<template>
    <div class="flex flex-col items-center">
        <div class="container mx-auto">
            <div class="max-w-md mx-auto my-5 bg-white p-5">
                <div class="text-center" v-if="comment_id === null">
                    <h1 class="my-3 text-3xl font-semibold text-gray-700 dark:text-gray-200">Send your comment</h1>
                    <p class="text-gray-400 dark:text-gray-400">Fill up the form below to send us a message.</p>
                </div>
                <div class="text-center" v-else>
                    <h1 class="my-3 text-3xl font-semibold text-gray-700 dark:text-gray-200">Replying comment</h1>
                    <p class="text-gray-400 dark:text-gray-400">Fill up the form below to send your reply.</p>
                </div>

                <div class="m-7">
                    <form method="POST" id="form">
                        <div class="mb-6">
                            <label for="name" class="block mb-2 text-sm text-gray-600 dark:text-gray-400">Full Name</label>
                            <input v-model="name"  type="text" name="name" id="name" placeholder="Type your full name" required class="w-full px-3 py-2 placeholder-gray-300 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-indigo-100 focus:border-indigo-300 dark:bg-gray-700 dark:text-white dark:placeholder-gray-500 dark:border-gray-600 dark:focus:ring-gray-900 dark:focus:border-gray-500" />
                        </div>

                        <div class="mb-6">
                            <label for="message" class="block mb-2 text-sm text-gray-600 dark:text-gray-400">Your Message</label>
                            <textarea v-model="comment" rows="5" name="message" id="message" placeholder="Your Message" class="w-full px-3 py-2 placeholder-gray-300 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-indigo-100 focus:border-indigo-300 dark:bg-gray-700 dark:text-white dark:placeholder-gray-500 dark:border-gray-600 dark:focus:ring-gray-900 dark:focus:border-gray-500" required></textarea>
                        </div>

                        <div class="mb-6">
                            <button @click="saveComment()" type="button" class="w-full px-3 py-4 text-white bg-indigo-500 rounded-md focus:bg-indigo-600 focus:outline-none">Send Message</button>
                        </div>
                        <p class="text-base text-center text-gray-400" id="result">
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
import axios from 'axios';
export default {
    props: {
        comment_id: null,
    },
    data() {
        return {
            name: '',
            comment: '',
        }
    },
    methods: {
        saveComment() {
            const t = this;

            if(this.name === '' || this.comment === '') {
                this.$dialog.alert({
                    title: 'Hey!',
                    text: 'Please fill all fields!',
                    icon: 'warning',
                });
                return;
            }

            axios.post('/comments', {
                name: this.name,
                comment: this.comment,
                comment_id: this.comment_id,
            }).then(({data}) => {
                t.$emit('hideModal', true)
                t.$root.$emit('newComment', this.comment_id)
            });
        }
    }
}
</script>
