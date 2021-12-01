<template>
    <div class="flex">
        <div class="flex-shrink-0 mr-3">
            <img class="mt-2 rounded-full w-8 h-8 sm:w-10 sm:h-10" src="https://images.unsplash.com/photo-1604426633861-11b2faead63c?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=200&h=200&q=80" alt="">
        </div>
        <div class="flex-1 border rounded-lg px-4 py-2 sm:px-6 sm:py-4 leading-relaxed">
            <strong>{{comment.name}}</strong> <span class="text-xs text-gray-400">{{ formatDate(comment.created_at) }}</span>
            <p class="text-sm">
                {{comment.comment}}
            </p>
            <div class="mt-4 flex items-center space-x-2" v-if="checkLevel()">
                <div class="flex -space-x-2 mr-2" v-if="comment.comments_count">
                    <img class="rounded-full w-6 h-6 border border-white" src="https://images.unsplash.com/photo-1554151228-14d9def656e4?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=100&h=100&q=80" alt="">
                    <img class="rounded-full w-6 h-6 border border-white" src="https://images.unsplash.com/photo-1513956589380-bad6acb9b9d4?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=100&h=100&q=80" alt="">
                </div>
                <button @click="fetchComments" class="text-sm text-gray-500 font-semibold" v-if="comment.comments_count">
                    See Replies
                </button>
                <button v-if="checkLevel()" @click="replyMessage" class="bg-blue-500 hover:bg-blue-700 text-sm text-white font-bold py-2 px-4 rounded-full">Reply this comment</button>
            </div>
            <ul
                v-if="checkLevel()"
                class="flex flex-col space-y-4 mt-3"
            >
                <comment-view v-for="(comment, index) in comments"
                              :key="comment.id"
                              :level="getLevel()"
                              :comment="comment"
                              :class="[index === comments.length - 1 ? '' : 'mb-6']">
                </comment-view>
            </ul>
            <div class="flex flex-col justify-center items-center mt-3">
                <button v-if="current_page != last_page" @click="loadMoreComments" class="bg-green-500 hover:bg-blue-700 text-sm text-white font-bold py-2 px-4 rounded-full">
                    Load More
                </button>
            </div>
        </div>
    </div>
</template>
<script>
import axios from "axios";

export default {
    name: "comment-view",
    props: {
        level: {
            required: false,
            type: Number,
        },
        comment: {
            required: true,
            type: Object,
        }
    },
    mounted() {
        this.$root.$on('newComment', (parent) => {
            if(parent === this.comment.id){
                this.fetchComments()
            }
        });
    },
    data() {
        return {
            comments: [],
            next_page: 1,
            current_page: 1,
            last_page: 1,
        }
    },
    methods: {
        formatDate(dateRaw) {
            const date = new Date(dateRaw);
            return date.toLocaleString();
        },
        replyMessage() {
            this.$root.$emit('replyMessage', this.comment.id);
        },
        checkLevel() {
            return this.level < 3
        },
        getLevel() {
            return this.level + 1;
        },
        fetchComments() {
            const t = this;

            axios.get('/comments', {
                params: {
                    comment_id: this.comment.id
                }
            }).then(({data}) => {
                t.comments = data.data;
                t.next_page = data.current_page + 1;
                t.last_page = data.last_page;
                t.current_page = data.current_page;
            })
        },
        loadMoreComments() {
            const t = this;
            let actual_comments = t.comments;

            axios.get('/comments', {
                params: {
                    page: this.next_page,
                    comment_id: this.comment.id,
                },
            })
                .then(({data}) => {
                    actual_comments = actual_comments.concat(data.data);
                    t.comments = actual_comments;
                    t.next_page = data.current_page + 1;
                    t.last_page = data.last_page;
                    t.current_page = data.current_page;
                })
        }
    }
}
</script>
