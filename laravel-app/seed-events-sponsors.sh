#!/bin/bash

echo "========================================"
echo "   SEEDERS DE EVENTOS Y PATROCINADORES"
echo "========================================"
echo

echo "Ejecutando seeder de patrocinadores..."
docker-compose exec app php artisan db:seed --class=SponsorSeeder
if [ $? -ne 0 ]; then
    echo "ERROR: No se pudo ejecutar el seeder de patrocinadores"
    exit 1
fi

echo
echo "Ejecutando seeder de eventos..."
docker-compose exec app php artisan db:seed --class=EventSeeder
if [ $? -ne 0 ]; then
    echo "ERROR: No se pudo ejecutar el seeder de eventos"
    exit 1
fi

echo
echo "Ejecutando seeder de inscripciones de eventos..."
docker-compose exec app php artisan db:seed --class=EventRegistrationSeeder
if [ $? -ne 0 ]; then
    echo "ERROR: No se pudo ejecutar el seeder de inscripciones"
    exit 1
fi

echo
echo "========================================"
echo "   SEEDERS COMPLETADOS EXITOSAMENTE"
echo "========================================"
echo
echo "Los siguientes datos han sido creados:"
echo "- Patrocinadores con asociaciones a proyectos"
echo "- Eventos de diferentes tipos"
echo "- Inscripciones de eventos"
echo
