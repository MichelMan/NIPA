<?php

namespace NIPA\ProjetBundle\Manager;

abstract class BaseManager
{
    protected function persistAndFlush($entity)
    {
        $this->em->persist($entity);
        $this->em->flush();
    }
    
    protected function deleteAndFlush($entity)
    {
        $this->em->remove($entity);
        $this->em->flush();
    }
}
