<?php

namespace NIPA\ProjetBundle\Repository;

/**
 * DemandeInstanceRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class DemandeInstanceRepository extends \Doctrine\ORM\EntityRepository
{
    
    public function getInstanceProjetCadrage()
    {
        $query = $this->_em->createQuery('SELECT count(a) FROM NIPAProjetBundle:DemandeInstance a JOIN a.refPhase r WHERE a.type = :type AND r.nom = :phase');
        $query->setParameter('type', "Projet");
        $query->setParameter('phase', "Cadrage");

        // Utilisation de getSingleResult car la requête ne doit retourner qu'un seul résultat
        return $query->getSingleResult();
    }       
    
    public function getInstanceProjetEtude()
    {
        $query = $this->_em->createQuery('SELECT count(a) FROM NIPAProjetBundle:DemandeInstance a JOIN a.refPhase r WHERE a.type = :type AND r.nom = :phase');
        $query->setParameter('type', "Projet");
        $query->setParameter('phase', "Etude");

        // Utilisation de getSingleResult car la requête ne doit retourner qu'un seul résultat
        return $query->getSingleResult();
    } 
    
    public function getInstanceProjetDeveloppement()
    {
        $query = $this->_em->createQuery('SELECT count(a) FROM NIPAProjetBundle:DemandeInstance a JOIN a.refPhase r WHERE a.type = :type AND r.nom = :phase');
        $query->setParameter('type', "Projet");
        $query->setParameter('phase', "Développement");

        // Utilisation de getSingleResult car la requête ne doit retourner qu'un seul résultat
        return $query->getSingleResult();
    } 
    
    public function getInstanceProjetRecette()
    {
        $query = $this->_em->createQuery('SELECT count(a) FROM NIPAProjetBundle:DemandeInstance a JOIN a.refPhase r WHERE a.type = :type AND r.nom = :phase');
        $query->setParameter('type', "Projet");
        $query->setParameter('phase', "Recette");

        // Utilisation de getSingleResult car la requête ne doit retourner qu'un seul résultat
        return $query->getSingleResult();
    } 
    
    public function getInstanceProjetMEP()
    {
        $query = $this->_em->createQuery('SELECT count(a) FROM NIPAProjetBundle:DemandeInstance a JOIN a.refPhase r WHERE a.type = :type AND r.nom = :phase');
        $query->setParameter('type', "Projet");
        $query->setParameter('phase', "MEP");

        // Utilisation de getSingleResult car la requête ne doit retourner qu'un seul résultat
        return $query->getSingleResult();
    } 
    
    public function getInstanceProjetVSR()
    {
        $query = $this->_em->createQuery('SELECT count(a) FROM NIPAProjetBundle:DemandeInstance a JOIN a.refPhase r WHERE a.type = :type AND r.nom = :phase');
        $query->setParameter('type', "Projet");
        $query->setParameter('phase', "VSR");

        // Utilisation de getSingleResult car la requête ne doit retourner qu'un seul résultat
        return $query->getSingleResult();
    } 
    
    public function getLastInstanceProjet($phase)
    {
        $query = $this->_em->createQuery('SELECT a FROM NIPAProjetBundle:DemandeInstance a JOIN a.refPhase r WHERE a.type = :type AND r.nom = :phase ORDER BY a.reference DESC');
        $query->setParameter('type', "Projet");
        $query->setParameter('phase', $phase);

        // Utilisation de getSingleResult car la requête ne doit retourner qu'un seul résultat
        $query->setMaxResults(1);
        return $query->getSingleResult();
    }     
}
