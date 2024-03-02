<?php

namespace App\Form\DataTransformer;

use App\Entity\Tag;
use App\Repository\TagRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\PersistentCollection;
use Symfony\Component\Form\DataTransformerInterface;

readonly class TagTransformer implements DataTransformerInterface
{

    public function __construct(
        private TagRepository $repository,
    )
    {
    }

    /**
     * @param PersistentCollection<Tag> $value
     */
    public function transform($value): string
    {
        if (null === $value) {
            return '';
        }
        $arr = [];
        foreach ($value as $tag) {
            $arr[] = $tag->getName();
        }

        return implode(',', $arr);
    }


    public function reverseTransform(mixed $value = null): ArrayCollection
    {
        if (!$value) {
            return new ArrayCollection();
        }

        $items = array_unique(array_map('trim', explode(',', $value)));

        $tags = new ArrayCollection();
        foreach ($items as $item) {
            $tag = $this->repository->findOneBy(['name' => $item]);
            if (!$tag) {
                $tag = (new Tag)->setName($item);
            }

            $tags->add($tag);
        }
        return $tags;
    }
}