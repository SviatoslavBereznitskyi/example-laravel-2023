<?php

declare(strict_types=1);

namespace App\Http\Admin\Blog;

use AdminColumn;
use AdminDisplay;
use AdminForm;
use AdminFormElement;
use Illuminate\Database\Eloquent\Model;
use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Contracts\Initializable;
use SleepingOwl\Admin\Section;

/**
 * Class CategoryController.
 *
 * @property \App\Models\Blog\Category $model
 *
 * @see https://sleepingowladmin.ru/#/ru/model_configuration_section
 */
class CategoryController extends Section implements Initializable
{
    /**
     * @var bool
     */
    protected $checkAccess = false;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $alias;

    /**
     * Initialize class.
     */
    public function initialize(): void
    {
    }

    /**
     * @param array $payload
     *
     * @return DisplayInterface
     */
    public function onDisplay($payload = [])
    {
        $columns = [
            AdminColumn::link('title', 'Title', 'created_at')
                ->setSearchCallback(static function ($column, $query, $search) {
                    return $query
                        ->orWhere('title', 'like', '%' . $search . '%');
                })
                ->setOrderable(static function ($query, $direction): void {
                    $query->orderBy('created_at', $direction);
                }),
            AdminColumn::text('created_at', 'Created / updated', 'updated_at')
                ->setWidth('160px')
                ->setOrderable(static function ($query, $direction): void {
                    $query->orderBy('updated_at', $direction);
                })
                ->setSearchable(false),
        ];

        $display = AdminDisplay::datatables()
            ->setName('firstdatatables')
            ->setOrder([[0, 'asc']])
            ->setDisplaySearch(true)
            ->paginate(25)
            ->setColumns($columns)
            ->setHtmlAttribute('class', 'table-primary table-hover th-center');

        $display->getColumnFilters()->setPlacement('card.heading');

        return $display;
    }

    /**
     * @param int|null $id
     * @param array $payload
     *
     * @return FormInterface
     */
    public function onEdit($id = null, $payload = [])
    {
        return AdminForm::card()->addBody([
            AdminFormElement::text('slug', 'Slug')->required(),
            AdminDisplay::tabbed()->setTabs(static function () {
                $locales = config('translatable.locales');
                foreach ($locales as $locale) {
                    $tabs[] = AdminDisplay::tab(
                        AdminForm::elements([
                            AdminFormElement::text("title:{$locale}", __('Title'))->required(),
                        ])
                    )->setLabel(__("{$locale}"));
                }
                return $tabs;
            }),
            AdminDisplay::tabbed()->setTabs(static function () {
                $locales = config('translatable.locales');
                foreach ($locales as $locale) {
                    $seo_tabs[] = AdminDisplay::tab(
                        AdminForm::elements([
                            AdminFormElement::html('SEO parameters'),
                            AdminFormElement::belongsTo('seoParameter', [
                                AdminFormElement::text('title:' . $locale, 'Title ' . $locale)->required(),
                                AdminFormElement::text('meta_title:' . $locale, 'Meta Title ' . $locale)->required(),
                                AdminFormElement::textarea('meta_description:' . $locale, 'Meta Description ' . $locale)->required(),
                            ]),
                        ])
                    )->setLabel(__("SEO_{$locale}"));
                }
                return $seo_tabs;
            }),
        ]);
    }

    /**
     * @param mixed $payload
     * @return FormInterface
     */
    public function onCreate($payload = [])
    {
        return $this->onEdit(null, $payload);
    }

    /**
     * @return bool
     */
    public function isDeletable(Model $model)
    {
        return !$model->is_default;
    }

    /**
     * @param mixed $id
     */
    public function onRestore($id): void
    {
        // remove if unused
    }
}
