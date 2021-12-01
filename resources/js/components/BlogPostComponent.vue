<template>
    <div>
        <div class="container w-full md:max-w-3xl mx-auto pt-20">
            <div class="w-full px-4 md:px-6 text-xl text-gray-800 leading-normal" style="font-family:Georgia,serif;">

                <div class="font-sans">
                    <p class="text-base md:text-sm text-green-500 font-bold">
                    <h1 class="font-bold font-sans break-normal text-gray-900 pt-6 pb-2 text-3xl md:text-4xl">Welcome to Eduardo Test Blog</h1>
                    <p class="text-sm md:text-base font-normal text-gray-600">Published 30 November 2021</p>

                    <p class="py-6">Sed dignissim lectus ut tincidunt vulputate. Fusce tincidunt lacus purus, in mattis tortor sollicitudin pretium. Phasellus at diam posuere, scelerisque nisl sit amet, tincidunt urna. Cras nisi diam, pulvinar ut molestie eget, eleifend ac magna. Sed at lorem condimentum, dignissim lorem eu, blandit massa. Phasellus eleifend turpis vel erat bibendum scelerisque. Maecenas id risus dictum, rhoncus odio vitae, maximus purus. Etiam efficitur dolor in dolor molestie ornare. Aenean pulvinar diam nec neque tincidunt, vitae molestie quam fermentum. Donec ac pretium diam. Suspendisse sed odio risus. Nunc nec luctus nisi. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Duis nec nulla eget sem dictum elementum.</p>

                    <div class="flex flex-row justify-between">
                        <h2 class="font-bold font-sans break-normal text-gray-900 pt-6 pb-2 text-xl md:text-4xl">Comments</h2>
                        <button @click="openModal()" type="button"
                                class="p-4 bg-green-500 text-white text-base font-semibold uppercase py-2 rounded-full shadow hover:bg-green-400">Share your opinion</button>
                    </div>

                    <comments-list :level="0"/>
                </div>
            </div>
        </div>
        <t-modal v-model="showModal">
            <comment :comment_id="comment_id" @hideModal="hideModal"/>
        </t-modal>
    </div>
</template>

<script>
import Comment from './CommentFormComponent'
import CommentsList from './CommentsListComponent'

export default {
    components: {
        Comment,
        CommentsList,
    },
    mounted() {
        this.$root.$on('replyMessage', (parent) => this.openModal(parent));

        this.$root.$on('newComment', () => {
            this.$dialog.alert({
                title: 'Yeah!',
                text: 'Thanks for your comment!',
                icon: 'success',
            });
        });
    },
    data() {
        return {
            showModal: false,
            comment_id: null,
            messageSuccess: false,
        }
    },
    methods: {
        openModal(comment_id = null) {
            this.comment_id = comment_id;
            this.showModal = true;
        },
        hideModal (value) {
            this.showModal = false;
        }
    }
}
</script>
