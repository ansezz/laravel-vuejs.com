<?php

namespace Core\Controllers\Api;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Core\Controllers\Api\Response\ResponseBuilder;
use Core\Services\LanguageService;
use Core\Services\PostService;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Themosis\Facades\Config;
use Themosis\Facades\Route;

/**
 * Class PostController
 * @package Core\Controllers\Api
 */
class PostController extends ApiBaseController
{
    const DEFAULT_TYPE = 'post';
    /** @var PostService */
    protected $postService;

    /** @var LanguageService */
    protected $languageService;

    public function __construct(
        ResponseBuilder $responseBuilder,
        PostService $postService,
        LanguageService $languageService
    )
    {
        parent::__construct($responseBuilder);

        $this->postService = $postService;
        $this->languageService = $languageService;

        $params = Route::current()->parameters();
        $postType = $params['type'];
        Route::current()->forgetParameter('type');

        if (!in_array($postType, Config::get('laravelvuejs.post_types'), true))
            throw new RouteNotFoundException();

        $this->postService->setPostType([$postType]);
    }

    /**
     * @api {get} :local/post/:id Get a single post
     * @apiName GetPost
     * @apiGroup Posts
     *
     * @apiParam {String} locale fr|ar
     * @apiParam {Number} id Unique ID of the Post.
     *
     * @apiSuccess {Object[]} post Object containing post information.
     * @apiSuccess {number} post.id ID of the post.
     * @apiSuccess {String} post.title Title of the post.
     * @apiSuccess {String} post.slug Slug of the post.
     * @apiSuccess {String} post.content Content of the post.
     * @apiSuccess {String} post.image Featured image of the post.
     * @apiSuccess {String[]} post.terms taxonomies of the post.
     * @apiSuccess {String[]} post.author author of the post.
     * @apiSuccess {String[]} post.keywords keywords of the post.
     * @apiSuccess {String} post.main_category Main category of the post.
     *
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *          "id": 1,
     *          "title": "Title of the post",
     *          "slug": "slug-of-the-post",
     *          "type": "post",
     *          "content": "Content of post with ID 1",
     *          "image": "http://dev.nexstarter.com/content/uploads/2018/07/Asset-1@1x-1.png",
     *          'author': {
     *              'id': 1,
     *              'slug': "nextmedia",
     *              'name': "Nextmedia",
     *              'first_name": "karkar",
     *              'last_name": "Benabdou",
     *              'avatar': "//secure.gravatar.com/avatar/b032b0794d92f1afb889ced465ddecc9?d=mm"
     *          },
     *          "main_category": "Non classé",
     *          "categories": [
     *          {
     *              "id": 2,
     *              "type": "category",
     *              "name": "Sport",
     *              "slug": "sport",
     *              "description": null,
     *              "group": 0,
     *              "total": 11,
     *              "locale": "fr"
     *          },
     *          {
     *              "id": 4,
     *              "type": "category",
     *              "name": "Maroc",
     *              "slug": "maroc",
     *              "description": null,
     *              "group": 0,
     *              "total": 6,
     *              "locale": "fr"
     *          },
     *          "tags": [
     *          {
     *              "id": 29,
     *              "type": "post_tag",
     *              "name": "Football",
     *              "slug": "football",
     *              "description": null,
     *              "group": 0,
     *              "total": 1,
     *              "locale": null
     *          },
     *          {
     *              "id": 30,
     *              "type": "post_tag",
     *              "name": "Maroc",
     *              "slug": "maroc",
     *              "description": null,
     *              "group": 0,
     *              "total": 1,
     *              "locale": null
     *          },
     *          "keywords": [
     *              "sport",
     *              "monde",
     *              "nextstarter"
     *          ],
     *          "keywords_str": "Non classé,Sport,bonjour,monde,nextstarter",
     *          "format": false,
     *          "locale": "fr",
     *          "created": "2018-07-13 02:07:17",
     *          "updated": "2018-08-13 20:08:52"
     *      }
     *
     * @apiError PostNotFound The id of the Post was not found.
     *
     * @apiErrorExample Error-Response:
     *     HTTP/1.1 404 Not Found
     *     {
     *       "status": 404,
     *       "error": "not found"
     *     }
     */
    public function show($locale, $arg)
    {
        try {
            /** @var array $post */
            $post = $this->postService->getByIdOrSlug($arg, $locale);

            return $this->responseBuilder->withItem('post', $post);
        } catch (ModelNotFoundException $e) {
            return $this->responseBuilder->withNotFound('not found');
        }

    }

    /**
     * @api {get} :local/posts Get published posts
     * @apiName GetPosts
     * @apiGroup Posts
     *
     * @apiParam {String} locale fr|ar
     *
     * @apiParam {Number} [page=1]
     * @apiParam {Number} [pages=1]
     * @apiParam {Number} [perPage=15]
     *
     * @apiSuccess {number} total total posts.
     * @apiSuccess {number} perPage per page.
     * @apiSuccess {number} page page.
     * @apiSuccess {number} pages pages.
     * @apiSuccess {Object[]} posts array of posts
     *
     */
    public function index($locale = null)
    {
        $perPage = is_null($this->request->get('perPage')) ? 15 : $this->request->get('perPage');
        $page = is_null($this->request->get('page')) ? 1 : $this->request->get('page');

        try {
            $posts = $this->postService->all($page, $perPage, $locale);
        } catch (ModelNotFoundException $e) {
            return $this->responseBuilder->withNotFound('not found');
        }

        return $this->responseBuilder->withItems('post', $posts);
    }

    /**
     * @api {get} :local/posts/featured Get published featured posts
     * @apiName GetFeaturedPosts
     * @apiGroup Posts
     *
     * @apiParam {String} locale fr|ar
     *
     * @apiParam {Number} [page=1]
     * @apiParam {Number} [perPage=15]
     *
     * @apiSuccess {number} total total posts.
     * @apiSuccess {number} perPage per page.
     * @apiSuccess {number} page page.
     * @apiSuccess {number} pages pages.
     * @apiSuccess {Object[]} posts array of posts
     *
     */
    public function featured($locale = null)
    {
        $perPage = is_null($this->request->get('perPage')) ? 15 : $this->request->get('perPage');
        $page = is_null($this->request->get('page')) ? 1 : $this->request->get('page');

        try {
            $posts = $this->postService->getFeatured($page, $perPage, $locale);
        } catch (ModelNotFoundException $e) {
            return $this->responseBuilder->withNotFound('not found');
        }

        return $this->responseBuilder->withItems('post', $posts);
    }

    /**
     * @api {get} :local/posts/catagory/:arg Get published posts by category
     * @apiName GetPostsByCategory
     * @apiGroup Posts
     *
     * @apiParam {String} locale fr|ar
     *
     * @apiParam {Number} [page=1]
     * @apiParam {Number} [perPage=15]
     *
     * @apiSuccess {number} total total posts.
     * @apiSuccess {number} perPage per page.
     * @apiSuccess {number} page page.
     * @apiSuccess {number} pages pages.
     * @apiSuccess {Object[]} posts array of posts
     *
     */

    /**
     * @param null $locale
     * @param $arg
     * @return array
     */
    public function category($locale = null, $arg)
    {
        $perPage = is_null($this->request->get('perPage')) ? 15 : $this->request->get('perPage');
        $page = is_null($this->request->get('page')) ? 1 : $this->request->get('page');

        try {
            $posts = $this->postService->getByCategoryIdOrSlug($arg, $page, $perPage, $locale);
        } catch (ModelNotFoundException $e) {
            return $this->responseBuilder->withNotFound('Not found');
        }

        return $this->responseBuilder->withItems('post', $posts);
    }

    public function tag($locale = null, $arg)
    {
        $perPage = is_null($this->request->get('perPage')) ? 15 : $this->request->get('perPage');
        $page = is_null($this->request->get('page')) ? 1 : $this->request->get('page');

        try {
            /** FIXME: MD-45 */
            $posts = $this->postService->getByTag($arg, $page, $perPage, $locale);

        } catch (ModelNotFoundException $e) {
            return $this->responseBuilder->withNotFound('not found');
        }

        return $this->responseBuilder->withItems('post', $posts);
    }

    public function getRelatedPosts($locale = null, $arg)
    {

        $post = $this->postService->getByIdOrSlug($locale, $arg);
        td($post);
    }
}