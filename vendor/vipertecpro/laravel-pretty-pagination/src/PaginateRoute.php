<?php

namespace Vipertecpro\PaginateRoute;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Routing\RouteParameterBinder;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Request;
use Illuminate\Translation\Translator;

class PaginateRoute
{
    /**
     * @var Translator
     */
    protected $translator;

    /**
     * @var Router
     */
    protected $router;

    /**
     * @var UrlGenerator
     */
    protected $urlGenerator;

    /**
     * @var string|array
     */
    protected $pageKeyword;

    /**
     * @param Translator $translator
     * @param Router $router
     * @param UrlGenerator $urlGenerator
     */
    public function __construct(Translator $translator, Router $router, UrlGenerator $urlGenerator)
    {
        $this->translator = $translator;
        $this->router = $router;
        $this->urlGenerator = $urlGenerator;

        // Unfortunately we can't do this in the service provider since routes are booted first
        $this->translator->addNamespace('paginateroute', __DIR__.'/../resources/lang');

        $this->pageKeyword = $this->translator->get('paginateroute::paginateroute.page');
    }

    /**
     * Return the current page.
     *
     * @return int
     */
    public function currentPage()
    {
        $currentRoute = $this->router->getCurrentRoute();

        if (! $currentRoute) {
            return 1;
        }

        $query = $currentRoute->parameter('pageQuery');

        return (int) str_replace($this->pageKeyword.'/', '', $query) ?: 1;
    }

    /**
     * Check if the given page is the current page.
     *
     * @param int $page
     *
     * @return bool
     */
    public function isCurrentPage($page): bool
    {
        return $this->currentPage() === $page;
    }

    /**
     * Get the next page number.
     *
     * @param LengthAwarePaginator $paginator
     *
     * @return int|void
     */
    public function nextPage(LengthAwarePaginator $paginator)
    {
        if (! $paginator->hasMorePages()) {
            return null;
        }

        return $this->currentPage() + 1;
    }

    /**
     * Determine weather there is a next page.
     *
     * @param LengthAwarePaginator $paginator
     *
     * @return bool
     */
    public function hasNextPage(LengthAwarePaginator $paginator): bool
    {
        return $this->nextPage($paginator) !== null;
    }

    /**
     * Get the next page URL.
     *
     * @param LengthAwarePaginator $paginator
     *
     * @return string|void
     */
    public function nextPageUrl(LengthAwarePaginator $paginator)
    {
        $nextPage = $this->nextPage($paginator);

        if ($nextPage === null) {
            return null;
        }

        return $this->pageUrl($nextPage);
    }

    /**
     * Get the previous page number.
     *
     * @return int|void|null
     */
    public function previousPage()
    {
        if ($this->currentPage() <= 1) {
            return null;
        }

        return $this->currentPage() - 1;
    }

    /**
     * Determine wether there is a previous page.
     *
     * @return bool
     */
    public function hasPreviousPage(): bool
    {
        return $this->previousPage() !== null;
    }

    /**
     * Get the previous page URL.
     *
     * @param bool $full Return the full version of the URL in for the first page
     *                   Ex. /users/page/1 instead of /users
     *
     * @return string|void|null
     */
    public function previousPageUrl($full = false): ?string
    {
        $previousPage = $this->previousPage();

        if ($previousPage === null) {
            return null;
        }

        return $this->pageUrl($previousPage, $full);
    }

    /**
     * Get all urls in an array.
     *
     * @param LengthAwarePaginator $paginator
     * @param bool                                                  $full      Return the full version of the URL in for the first page
     *                                                                         Ex. /users/page/1 instead of /users
     *
     * @return array
     */
    public function allUrls(LengthAwarePaginator $paginator, $full = false): array
    {
        if (! $paginator->hasPages()) {
            return [];
        }

        $urls = [];
        $left = $this->getLeftPoint($paginator);
        $right = $this->getRightPoint($paginator);
        for ($page = $left; $page <= $right; $page++) {
            $urls[$page] = $this->pageUrl($page, $full);
        }

        return $urls;
    }

    /**
     * Get the left most point in the pagination element.
     *
     * @param LengthAwarePaginator $paginator
     * @return int
     */
    public function getLeftPoint(LengthAwarePaginator $paginator): int
    {
        $side = $paginator->onEachSide;
        $current = $paginator->currentPage();
        $last = $paginator->lastPage();

        if (! empty($side)) {
            $x = $current + $side;
            $offset = $x >= $last ? $x - $last : 0;
            $left = $current - $side - $offset;
        }
        if(!isset($left) || $left < 1){
            return 1;
        }
        return $left;
    }

    /**
     * Get the right or last point of the pagination element.
     *
     * @param LengthAwarePaginator $paginator
     * @return int
     */
    public function getRightPoint(LengthAwarePaginator $paginator): int
    {
        $side = $paginator->onEachSide;
        $current = $paginator->currentPage();
        $last = $paginator->lastPage();

        if (! empty($side)) {
            $offset = $current <= $side ? $side - $current + 1 : 0;
            $right = $current + $side + $offset;
        }
        if(!isset($right) || $right > $last){
            return $last;
        }
        return $right;
    }

    /**
     * Render a plain html list with previous, next and all urls. The current page gets a current class on the list item.
     *
     * @param LengthAwarePaginator $paginator
     * @param bool $full Return the full version of the URL in for the first page
     *                                                                                 Ex. /users/page/1 instead of /users
     * @param string $class Include class on pagination list
     *                                                                                 Ex. <ul class="pagination">
     * @param bool $additionalLinks Include prev and next links on pagination list
     *
     * @return string
     */

    public function renderPageList(LengthAwarePaginator $paginator, $full = false, $class = null, $additionalLinks = false): string
    {
        $urls = $this->allUrls($paginator, $full);
        if ($class !== null) {
            $class = " class=\"$class\"";
        }
        $listItems = "<ul{$class}>";
        if ($this->hasPreviousPage() && $additionalLinks) {
            $listItems .= "<li class='page-item'> <a class='page-link' href=\"{$this->previousPageUrl()}\">&laquo;</a></li>";
        }
        foreach ($urls as $i => $url) {
            $pageNum = $i;
            $css = ' class="page-item"';
            $link = "<a class='page-link' href=\"{$url}\">{$pageNum}</a>";
            if ($pageNum === $this->currentPage()) {
                $css = ' class="page-item active"';
                $link = "<span class='page-link' href=\"{$url}\">{$pageNum}</span>";
            }
            $listItems .= "<li{$css}>$link</li>";
        }
        if ($this->hasNextPage($paginator) && $additionalLinks) {
            $listItems .= "<li class='page-item'> <a class='page-link' href=\"{$this->nextPageUrl($paginator)}\">&raquo;</a></li>";
        }
        $listItems .= '</ul>';
        return $listItems;
    }
    /**
     * Render html link tags for SEO indication of previous and next page.
     *
     * @param LengthAwarePaginator $paginator
     * @param bool                                                  $full       Return the full version of the URL in for the first page
     *                                                                          Ex. /users/page/1 instead of /users
     *
     * @return string
     */
    public function renderRelLinks(LengthAwarePaginator $paginator, $full = false): string
    {
        $urls = $this->allUrls($paginator, $full);

        $linkItems = '';

        foreach ($urls as $i => $url) {
            $pageNum = $i + 1;

            switch ($pageNum - $this->currentPage()) {
                case -1:
                    $linkItems .= "<link rel=\"prev\" href=\"{$url}\" />";
                    break;
                case 1:
                    $linkItems .= "<link rel=\"next\" href=\"{$url}\" />";
                    break;
            }
        }

        return $linkItems;
    }

    /**
     * @param LengthAwarePaginator $paginator
     * @param bool $full Return the full version of the URL in for the first page
     *                                                                         Ex. /users/page/1 instead of /users
     *
     * @return string
     * @deprecated in favor of renderPageList.
     */
    public function renderHtml(LengthAwarePaginator $paginator, $full = false): string
    {
        return $this->renderPageList($paginator, $full);
    }

    /**
     * Generate a page URL, based on the request's current URL.
     *
     * @param int  $page
     * @param bool $full Return the full version of the URL in for the first page
     *                   Ex. /users/page/1 instead of /users
     *
     * @return string|null
     */
    public function pageUrl($page, $full = false): string
    {
        $currentPageUrl = $this->router->getCurrentRoute()->uri();

        $url = $this->addPageQuery(str_replace('{pageQuery?}', '', $currentPageUrl), $page, $full);

        foreach ((new RouteParameterBinder($this->router->getCurrentRoute()))->parameters(app('request')) as $parameterName => $parameterValue) {
            $url = str_replace(['{'.$parameterName.'}', '{'.$parameterName.'?}'], $parameterValue, $url);
        }

        $query = Request::getQueryString();

        $query = $query
            ? '?'.$query
            : '';

        return $this->urlGenerator->to($url).$query;
    }

    /**
     * Append the page query to a URL.
     *
     * @param string $url
     * @param int    $page
     * @param bool   $full Return the full version of the URL in for the first page
     *                     Ex. /users/page/1 instead of /users
     *
     * @return string
     */
    public function addPageQuery($url, $page, $full = false): string
    {
        // If the first page's URL is requested and $full is set to false, there's nothing to be added.
        if ($page === 1 && ! $full) {
            return $url;
        }

        return trim($url, '/')."/{$this->pageKeyword}/{$page}";
    }

    /**
     * Register the Route::paginate macro.
     */
    public function registerMacros(): void
    {
        $pageKeyword = $this->pageKeyword;
        $router = $this->router;

        $router->macro('paginate', function ($uri, $action) use ($pageKeyword, $router) {
            $route = null;

            $router->group(
                ['middleware' => 'Vipertecpro\PaginateRoute\SetPageMiddleware'],
                function () use ($pageKeyword, $router, $uri, $action, &$route) {
                    $route = $router->get($uri.'/{pageQuery?}', $action)->where('pageQuery', $pageKeyword.'/[0-9]+');
                });

            return $route;
        });
    }
}
