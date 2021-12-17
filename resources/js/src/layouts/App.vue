<template>
    <div>
        <header>
            <h1 class="logo">Blog Code challenge</h1>
        </header>
<!--
        <nav>
            <ul>
                <li class="nav-item"><a href="#">Home</a></li>
                <li class="nav-item"><a href="#">Blog</a></li>
            </ul>
            <div class="menu-bar" @click="menuBarClick">
                Menu
                <span class="hamburger-icon menu-container">
                    <div class="bar1"></div>
                    <div class="bar2"></div>
                    <div class="bar3"></div>
                </span>
            </div>
        </nav> -->

        <div class="container">
            <div class="section">
                <div class="col span_3_of_3">
                    <div class="blog-post">
                        <h1 class="blog-title">
                            {{ post.title }}
                        </h1>
                        <h2 class="date my-4">Posted {{ convertData(post.created_at) }}</h2>
                        <p class="blog-content">
                            {{ post.body }}
                        </p>
                        <a>Thanks for Reading.</a>
                    </div>
                    <div class="blog-post">
                        <comment :comments-count="post.comments_count" :comments="post.comments" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import Comment from "./../components/Comment.vue";

export default {
    components: {
        Comment
    },
    data() {
        return {
            post: {},
        }
    },
    mounted() {
        this.getPostComment();
    },
    methods: {
        getPostComment() {
            axios.get('api/posts/1')
                .then( (res) => {
                    this.post = res.data.data;
                    console.log("post", this.post);
                })
        },
        menuBarClick() {
            let nav = document.querySelector('nav ul');
            nav.classList.toggle('reveal');
        },
        convertData(_date) {
            return new Date(_date).toDateString();
        }
    }
}
</script>
