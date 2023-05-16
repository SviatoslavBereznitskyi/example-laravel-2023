<?php

declare(strict_types=1);

namespace App\Http\Admin\Blog;

use AdminColumn;
use AdminDisplay;
use AdminForm;
use AdminFormElement;
use App\Models\Blog\Category;
use App\Services\ImageService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Contracts\Initializable;
use SleepingOwl\Admin\Section;
use Storage;

/**
 * Class BlogController.
 *
 * @property \App\Models\Blog\Blog $model
 *
 * @see https://sleepingowladmin.ru/#/ru/model_configuration_section
 */
class BlogController extends Section implements Initializable
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

    private ImageService $imageService;

    /**
     * Initialize class.
     */
    public function initialize(): void
    {
        $this->imageService = resolve(ImageService::class);
    }

    /**
     * @param array $payload
     *
     * @return DisplayInterface
     */
    public function onDisplay($payload = [])
    {
        $columns = [
            AdminColumn::link('slug', 'Slug')->setSearchCallback(static function ($column, $query, $search) {
                return $query
                    ->orWhere('slug', 'like', '%' . $search . '%');
            }),
            AdminColumn::text('title', 'Title', 'created_at')
                ->setSearchable(false)
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
            AdminFormElement::text('slug', 'Slug')->required()->unique(),
            AdminFormElement::text('tagsAdmin', 'Tags')->setHelpText('розділіть теги комою'),
            AdminFormElement::select('category_id', 'Category', Category::class)->required(),
            AdminFormElement::html('<hr>'),
            AdminFormElement::hasMany('images', [
                AdminFormElement::image('uri', 'Image')->setSaveCallback(function (UploadedFile $file) {
                    $image = $this->imageService->thumbnailResize($file);

                    $path = 'blog/' . Str::uuid()->toString() . '.jpg';
                    if (Storage::disk('s3-public')->fileExists($path)) {
                        Storage::disk('s3-public')->delete($path);
                    }
                    Storage::disk('s3-public')->put($path, $image);

                    return [
                        'path' => $path,
                        'value' => Storage::disk('s3-public')->url($path),
                    ];
                }),
            ])->setLabel('Images'),
            AdminDisplay::tabbed()->setTabs(static function () {
                $locales = config('translatable.locales');
                foreach ($locales as $locale) {
                    $tabs[] = AdminDisplay::tab(
                        AdminForm::elements([
                            AdminFormElement::text("title:{$locale}", __('Title'))->required(),
                            AdminFormElement::textarea('description:' . $locale, 'Short Description H1 ' . $locale)->required(),
                            AdminFormElement::wysiwyg('content-' . $locale, 'Content ' . $locale)->required(),
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
        return true;
    }

    /**
     * @param mixed $id
     */
    public function onRestore($id): void
    {
        // remove if unused
    }
}
