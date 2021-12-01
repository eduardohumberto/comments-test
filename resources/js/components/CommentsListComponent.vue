<template>
    <div class="space-y-4 my-5" v-if="comments.length">
        <comment v-for="(comment, index) in comments"
                 :key="comment.id"
                 :level="level"
                 :comment="comment"
                 :class="[index === comments.length - 1 ? '' : 'mb-6']">
        </comment>

        <div class="flex flex-col justify-center items-center">
            <button v-if="current_page != last_page" @click="loadMoreComments" class="bg-green-500 hover:bg-blue-700 text-sm text-white font-bold py-2 px-4 rounded-full">
                Load More
            </button>
        </div>

    </div>
    <div class="flex flex-row justify-center align-center my-5" v-else>
        <span class="text-2xl">No comments for this post :(</span>
    </div>
</template>
<script>
import axios from 'axios';
import Comment from './CommentViewComponent'
export default {
    components: {
        Comment,
    },
    mounted() {
        this.fetchComments();
        this.$root.$on('newComment', (parent) => {
            if(parent === null){
                this.fetchComments()
            }
        });
    },
    props: {
        comment_id: null,
        level: {
            type: Number,
            required: false,
        }
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
        fetchComments() {
            const t = this;

            axios.get('/comments')
                .then(({data}) => {
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
                    page: this.next_page
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
