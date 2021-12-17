<template>
    <div>
        <div class="col-md-12">
            <div class="header_comment">
                <div class="row">
                    <div class="col-md-6 text-left">
                        <span class="count_comment"
                            >{{ postCommentsCount }} Comments
                        </span>
                    </div>
                </div>
            </div>
            <div class="body_comment">
                <div class="row" v-if="showReply">
                    <div class="box_comment col-md-4 mb-1">
                        <input
                            class="commentar"
                            placeholder="Enter Your Name"
                            v-model="formData.name"
                            v-on:keyup.enter="submitComment"
                        />
                    </div>
                    <div class="box_comment col-md-12">
                        <textarea
                            class="commentar"
                            placeholder="Enter Your Message"
                            v-model="formData.message"
                            v-on:keyup.enter="submitComment"
                        ></textarea>
                        <div class="box_post">
                            <div class="pull-right">
                                <button
                                    type="button"
                                    value="1"
                                    @click="submitComment"
                                >
                                    Submit
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <ul id="list_comment" class="col-md-12">
                        <li class="box_result row"
                          v-for="(comment,key) in postComments" :key="key"
                        >
                            <div class="avatar_comment col-md-1">
                                <img
                                    src="https://static.xx.fbcdn.net/rsrc.php/v1/yi/r/odA9sNLrE86.jpg"
                                    alt="avatar"
                                />
                            </div>
                            <div class="result_comment col-md-11">
                                <h4>{{ comment.name }}</h4>
                                <p> {{ comment.message }} </p>
                                <div class="tools_comment">
                                    <a class="text-danger mx-2" @click="deleteComment(comment)"> delete </a>
                                    <a class="mx-2" @click="replyComment(comment)"> reply </a>
                                    <span> {{ convertData(comment.created_at) }} </span>
                                </div>
                                <ul class="child_replay" v-if="comment && comment.replies && comment.replies.length > 0">
                                    <li class="box_reply row"
                                      v-for="(reply,index) in comment.replies"
                                      :key="index"
                                    >
                                        <div class="avatar_comment col-md-1">
                                            <img
                                                src="https://static.xx.fbcdn.net/rsrc.php/v1/yi/r/odA9sNLrE86.jpg"
                                                alt="avatar"
                                            />
                                        </div>
                                        <div class="result_comment col-md-11">
                                            <h4>{{ reply.name }}</h4>
                                            <p> {{ reply.message }}
                                            <div class="tools_comment">
                                               <a class="text-danger mx-2" @click="deleteComment(comment)"> delete </a>
                                                <span>{{convertData(reply.created_at)}}</span>
                                            </div>
                                            <ul class="child_replay"></ul>
                                        </div>
                                    </li>
                                </ul>
                                <ul v-if="replyShowBox && comment.show_reply_box" class="child_replay">
                                  <div class="row">
                                    <div class="box_comment col-md-4 mb-1">
                                        <input
                                            class="commentar"
                                            placeholder="Enter Your Name"
                                            v-model="formData.name"
                                            v-on:keyup.enter="submitComment"
                                        />
                                    </div>
                                    <div class="box_comment col-md-12">
                                        <textarea
                                            class="commentar"
                                            placeholder="Enter Your Message"
                                            v-model="formData.message"
                                            v-on:keyup.enter="submitComment"
                                        ></textarea>
                                        <div class="box_post">
                                            <div class="pull-right">
                                                <button
                                                    type="button"
                                                    class="button-cancle"
                                                    value="1"
                                                    @click="cancleReply"
                                                >
                                                    cancle
                                                </button>
                                                <button
                                                    type="button"
                                                    value="1"
                                                    @click="submitComment"
                                                >
                                                    Submit
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                  </div>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: {
        comments: Array,
        commentsCount: Number,
    },
    data() {
        return {
            formData: {},
            postComments: [],
            postCommentsCount: '',
            replyShowBox: false,
            showReply: true,
        };
    },
    watch: {
      comments: function(_val) {
        this.postComments = _val;
      },
      commentsCount: function(_val) {
        this.postCommentsCount = _val;
      }
    },
    mounted() {
        //
    },
    methods: {
        submitComment() {
          axios.post("api/posts/1/comments", this.formData)
            .then( (res) => {
              this.postComments = res.data.data.comments;
              this.postCommentsCount = res.data.data.comments_count;
              this.replyShowBox = false;
              this.showReply = true;
              this.formData = {};
            })
            .catch( (res) => {
                alert(res.response.data.message);
            })
        },
        replyComment(_comment) {
          _comment.show_reply_box = true;
          this.formData.parent_id = _comment.id;
          this.replyShowBox = true;
          this.showReply = false;
        },
        cancleReply() {
          this.replyShowBox = false;
          this.showReply = true;
        },
        deleteComment(_comment) {
          console.log("called");
          axios.delete(`api/posts/1/comments/${_comment.id}`)
            .then( (res) => {
              this.postComments = res.data.data;
            })
        },
        convertData(_date) {
          return new Date(_date).toDateString();
        },
    },
};
</script>
<style>
.pull-right {
    float: right;
}
.pull-left {
    float: left;
}
.header_comment {
    font-size: 14px;
    overflow: hidden;
    border-bottom: 1px solid #e9ebee;
    line-height: 25px;
    margin-bottom: 24px;
    padding: 10px 0;
}
.sort_title {
    color: #4b4f56;
}
.sort_by {
    background-color: #f5f6f7;
    color: #4b4f56;
    line-height: 22px;
    cursor: pointer;
    vertical-align: top;
    font-size: 12px;
    font-weight: bold;
    vertical-align: middle;
    padding: 4px;
    justify-content: center;
    border-radius: 2px;
    border: 1px solid #ccd0d5;
}
.count_comment {
    font-weight: 600;
}
.body_comment {
    padding: 0 8px;
    font-size: 14px;
    display: block;
    line-height: 25px;
    word-break: break-word;
}
.avatar_comment {
    display: block;
}
.avatar_comment img {
    height: 48px;
    width: 48px;
}
.box_comment {
    display: block;
    position: relative;
    line-height: 1.358;
    word-break: break-word;
    border: 1px solid #d3d6db;
    word-wrap: break-word;
    background: #fff;
    box-sizing: border-box;
    cursor: text;
    font-family: Helvetica, Arial, sans-serif;
    font-size: 16px;
    padding: 0;
}
.box_comment textarea {
    min-height: 40px;
    padding: 12px 8px;
    width: 100%;
    border: none;
    resize: none;
}

.box_comment input {
    min-height: 40px;
    padding: 12px 8px;
    width: 100%;
    border: none;
    resize: none;
}
.box_comment textarea:focus {
    outline: none !important;
}
.box_comment input:focus {
    outline: none !important;
}
.box_comment .box_post {
    border-top: 1px solid #d3d6db;
    background: #f5f6f7;
    padding: 8px;
    display: block;
    overflow: hidden;
}
.box_comment label {
    display: inline-block;
    vertical-align: middle;
    font-size: 11px;
    color: #90949c;
    line-height: 22px;
}
.box_comment button {
    margin-left: 8px;
    background-color: #4267b2;
    border: 1px solid #4267b2;
    color: #fff;
    text-decoration: none;
    line-height: 22px;
    border-radius: 2px;
    font-size: 14px;
    font-weight: bold;
    position: relative;
    text-align: center;
}
.box_comment button:hover {
    background-color: #29487d;
    border-color: #29487d;
}
.button-cancle {
    background-color: #ad2424 !important;
    color: #f5f6f7 !important;
}
.box_comment .cancel:hover {
    background-color: #d0d0d0;
    border-color: #ccd0d5;
}
.box_comment img {
    height: 16px;
    width: 16px;
}
.box_result {
    margin-top: 24px;
}
.box_result .result_comment h4 {
    font-weight: 600;
    white-space: nowrap;
    color: #365899;
    cursor: pointer;
    text-decoration: none;
    font-size: 14px;
    line-height: 1.358;
    margin: 0;
    text-align: left;
}
.box_result .result_comment {
    display: block;
    overflow: hidden;
    padding: 0;
}
.child_replay {
    border-left: 1px dotted #d3d6db;
    background: #eaf1fd;
    margin-top: 12px;
    margin-right: 10px;
    list-style: none;
    padding: 10px;
    padding-left: 20px;
    padding-right: 20px;
}
.reply_comment {
    margin: 12px 0;
}
.box_result .result_comment p {
    margin: 4px 0;
    text-align: justify;
    color: #000000;
}
.box_result .result_comment .tools_comment {
    font-size: 12px;
    line-height: 1.358;
    text-align: left;
}
.box_result .result_comment .tools_comment a {
    color: #4267b2;
    cursor: pointer;
    text-decoration: none;
}
.box_result .result_comment .tools_comment span {
    color: #90949c;
}
.body_comment .show_more {
    background: #3578e5;
    border: none;
    box-sizing: border-box;
    color: #fff;
    font-size: 14px;
    margin-top: 24px;
    padding: 12px;
    text-shadow: none;
    width: 100%;
    font-weight: bold;
    position: relative;
    text-align: center;
    vertical-align: middle;
    border-radius: 2px;
}
</style>
