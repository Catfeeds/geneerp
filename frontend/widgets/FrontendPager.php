<?php

namespace frontend\widgets;

use yii\base\InvalidConfigException;
use yii\helpers\Html;
use yii\base\Widget;
/**
<div class="page">
    <div class="pagination">
        <?= FrontendPager::widget(['pagination' => $pages]); ?>
    </div>
</div>
.page{text-align: center; padding:10px 0 20px 0;}
.pagination{font-size: 0px; margin-right: -5px; padding-top: 15px; text-align: center;}
.pagination ul li{float: left;}
.pagination a{font-size: 12px; color: #888; display: inline-block; _display:inline; padding: 0 7px; border: 1px solid #ddd; margin-right: 5px; line-height: 26px;}
.pagination a.prev,.pagination a.next{padding: 0 15px;}
.pagination a:hover,
.pagination a.cur,
.pagination a.active,
.pagination li.active a,
.pagination li.active a:hover{background: #0066a5; color: #fff; border: 1px solid #0066a5;}
 */
class FrontendPager extends Widget {

    public $pagination;
    public $options = ['class' => 'pager'];
    public $linkOptions = [];
    public $pageCssClass = null;
    public $firstPageCssClass = 'previous';
    public $lastPageCssClass = 'last';
    public $prevPageCssClass = 'previous';
    public $nextPageCssClass = 'next';
    public $activePageCssClass = 'active';
    public $disabledPageCssClass = 'disabled';
    public $maxButtonCount = 10;
    public $nextPageLabel = '下一页';
    public $prevPageLabel = '上一页';
    public $firstPageLabel = false;
    public $lastPageLabel = false;
    public $registerLinkTags = false;
    public $hideOnSinglePage = true;

    public function init() {
        if ($this->pagination === null) {
            throw new InvalidConfigException('The pagination property must be set.');
        }
    }

    public function run() {
        if ($this->registerLinkTags) {
            $this->registerLinkTags();
        }
        echo $this->renderPageButtons();
    }

    protected function registerLinkTags() {
        $view = $this->getView();
        foreach ($this->pagination->getLinks() as $rel => $href) {
            $view->registerLinkTag(['rel' => $rel, 'href' => $href], $rel);
        }
    }

    protected function renderPageButtons() {
        $pageCount = $this->pagination->getPageCount();
        if ($pageCount < 2 && $this->hideOnSinglePage) {
            return '';
        }

        $buttons = [];
        $currentPage = $this->pagination->getPage();

        // first page
        $firstPageLabel = $this->firstPageLabel === true ? '1' : $this->firstPageLabel;
        if ($firstPageLabel !== false) {
            $buttons[] = $this->renderPageButton($firstPageLabel, 0, $this->firstPageCssClass, $currentPage <= 0, false);
        }

        // prev page
        if ($this->prevPageLabel !== false) {
            if (($page = $currentPage - 1) < 0) {
                $page = 0;
            }
            $buttons[] = $this->renderPageButton($this->prevPageLabel, $page, $this->prevPageCssClass, $currentPage <= 0, false);
        }

        // internal pages
        list($beginPage, $endPage) = $this->getPageRange();
        for ($i = $beginPage; $i <= $endPage; ++$i) {
            $buttons[] = $this->renderPageButton($i + 1, $i, null, false, $i == $currentPage);
        }

        // next page
        if ($this->nextPageLabel !== false) {
            if (($page = $currentPage + 1) >= $pageCount - 1) {
                $page = $pageCount - 1;
            }
            $buttons[] = $this->renderPageButton($this->nextPageLabel, $page, $this->nextPageCssClass, $currentPage >= $pageCount - 1, false);
        }

        // last page
        $lastPageLabel = $this->lastPageLabel === true ? $pageCount : $this->lastPageLabel;
        if ($lastPageLabel !== false) {
            $buttons[] = $this->renderPageButton($lastPageLabel, $pageCount - 1, $this->lastPageCssClass, $currentPage >= $pageCount - 1, false);
        }

        return implode('', $buttons);
    }

    protected function renderPageButton($label, $page, $class, $disabled, $active) {
        $options = ['class' => empty($class) ? $this->pageCssClass : $class];
        if ($active) {
            Html::addCssClass($options, $this->activePageCssClass);
        }
        if ($disabled) {
            Html::addCssClass($options, $this->disabledPageCssClass);
        }

        return Html::a($label, $this->pagination->createUrl($page), $options);
    }

    protected function getPageRange() {
        $currentPage = $this->pagination->getPage();
        $pageCount = $this->pagination->getPageCount();

        $beginPage = max(0, $currentPage - (int) ($this->maxButtonCount / 2));
        if (($endPage = $beginPage + $this->maxButtonCount - 1) >= $pageCount) {
            $endPage = $pageCount - 1;
            $beginPage = max(0, $endPage - $this->maxButtonCount + 1);
        }

        return [$beginPage, $endPage];
    }

}
