<?php

/*
 * This file is part of EC-CUBE
 *
 * Copyright(c) LOCKON CO.,LTD. All Rights Reserved.
 *
 * http://www.lockon.co.jp/
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Plugin\ProductReview\Form\Type\Admin;

use Eccube\Common\EccubeConfig;
use Eccube\Form\Type\Master\ProductStatusType;
use Eccube\Form\Type\Master\SexType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class ProductReviewType.
 * [商品レビュー]-[レビュー管理]用Form.
 */
class ProductReviewType extends AbstractType
{
    /**
     * @var EccubeConfig
     */
    protected $eccubeConfig;

    /**
     * ProductReviewType constructor.
     *
     * @param EccubeConfig $eccubeConfig
     */
    public function __construct(EccubeConfig $eccubeConfig)
    {
        $this->eccubeConfig = $eccubeConfig;
    }

    /**
     * Build form.
     *
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $config = $this->eccubeConfig;
        $builder
            ->add('id', HiddenType::class)
            ->add('create_date', HiddenType::class, [
                'label' => 'plugin.admin.product_review.list.posted.date',
                'mapped' => false,
            ])
            ->add('status', ProductStatusType::class, [
                'required' => true,
                'constraints' => [
                    new Assert\NotBlank(),
                ],
            ])
            ->add('reviewer_name', TextType::class, [
                'label' => 'plugin.admin.product_review.form.name.contributor',
                'required' => true,
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Length(['max' => $config['eccube_stext_len']]),
                ],
                'attr' => [
                    'maxlength' => $config['eccube_stext_len'],
                ],
            ])
            ->add('reviewer_url', TextType::class, [
                'label' => 'plugin.admin.product_review.form.authorURL',
                'required' => false,
                'constraints' => [
                    new Assert\Url(),
                    new Assert\Length(['max' => $config['eccube_stext_len']]),
                ],
                'attr' => [
                    'maxlength' => $config['eccube_stext_len'],
                ],
            ])
            ->add('sex', SexType::class, [
                'required' => false,
            ])
            ->add('recommend_level', ChoiceType::class, [
                'label' => 'plugin.admin.product_review.list.level',
                'choices' => array_flip([
                    '5' => '★★★★★',
                    '4' => '★★★★',
                    '3' => '★★★',
                    '2' => '★★',
                    '1' => '★',
                ]),
                'expanded' => false,
                'multiple' => false,
                'required' => true,
            ])
            ->add('title', TextType::class, [
                'label' => 'plugin.admin.product_review.form.comment.title',
                'required' => true,
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Length(['max' => $config['eccube_stext_len']]),
                ],
                'attr' => [
                    'maxlength' => $config['eccube_stext_len'],
                ],
            ])
            ->add('comment', TextareaType::class, [
                'label' => 'plugin.admin.product_review.form.comment.content',
                'required' => true,
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Length(['max' => $config['eccube_stext_len']]),
                ],
                'attr' => [
                    'maxlength' => $config['eccube_ltext_len'],
                ],
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'admin_product_review';
    }
}
