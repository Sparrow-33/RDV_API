<?php

    class Blog extends Controller
    {
        public function __construct()
        {
            $this->articleModel = $this->model('BlogModel');
        }

     //bring 3 articles from the database
        public function getThreeArticles()
        {
            $result = json_decode(file_get_contents('php://input'));

            $id = $result->id;
            $blog_id = $result->blog_id;


            $articles = $this->articleModel->getThreeArticles($id, $blog_id);

            if($articles){
                echo json_encode($articles);
            } else {
                echo json_encode(['error' => 'No articles found']);
            }


            
        }

        //function to like an article
        public function likeArticle()
        {
            $result = json_decode(file_get_contents('php://input'));

            $id = $result->id;
            $blog_id = $result->blog_id;

            $article = $this->articleModel->likeArticle($id, $blog_id);

            if($article)
            {
                echo json_encode(['success' => true]);
            } else
            {
                echo json_encode(['error' => false]);
            }
        }

        //function to unlike an article
        public function unlikeArticle()
        {
            $result = json_decode(file_get_contents('php://input'));

            $id = $result->id;
            $blog_id = $result->blog_id;

            $article = $this->articleModel->unlikeArticle($id, $blog_id);

            if($article)
            {
                echo json_encode(['success' => true]);
            } else
            {
                echo json_encode(['error' => false]);
            }
        }

        // already liked
        public function alreadyLiked()
        {
            $result = json_decode(file_get_contents('php://input'));

            $id = $result->id;
            $blog_id = $result->blog_id;

            $article = $this->articleModel->alreadyLiked($id, $blog_id);

            if($article)
            {
                echo json_encode(['message' => true]);
            } else
            {
                echo json_encode(['message' => false]);
            }
        }

        //function get number of likes
        public function getNumberOfLikes()
        {
            $result = json_decode(file_get_contents('php://input'));

            $blog_id = $result->blog_id;

            $num = $this->articleModel->getNumberOfLikes($blog_id);

            if($num)
            {
                echo json_encode(['message' => $num]);
            } else
            {
                echo json_encode(['message' => $num]);
            }
        }
        
        //function to get all articles

        public function getAllArticles(){

            $articles = $this->articleModel->getAllArticles();

            if($articles){
                echo json_encode($articles);
            } else {
                echo json_encode(['message' => false]);
            }


        }

        //delete comments

        public function deleteArticle(){

            $result = json_decode(file_get_contents('php://input'));

            $id = $result->id;
            $art = $this->articleModel->deleteArticle($id);

            if($art){
                echo json_encode(['message' => true]);
            } else {
                echo json_encode(['message' => false]);
            }
        
        }

        function myComments(){

            $result = json_decode(file_get_contents('php://input'));

            $UID = $result->id;
            $CID = $result->CID;
        }

        function countComment(){

            $comment = $this->articleModel->countComment();

            if($comment){
                echo json_encode($comment);
            } else {
                echo json_encode(['message' => false]);
            }

            
        }


        function countArticle(){

            $article = $this->articleModel->countArticle();

            if($article){
                echo json_encode($article);
            } else {
                echo json_encode(['message' => false]);
            }

        }

        function countUsers(){

            $users = $this->articleModel->countUsers();

            if($users){
                echo json_encode($users);
            } else {
                echo json_encode(['message' => false]);
            }

        }

        function countLikes(){
            $like = $this->articleModel->countLikes();

            if($like){
                echo json_encode($like);
            } else {
                echo json_encode(['message' => false]);
            }

        }




    }

      