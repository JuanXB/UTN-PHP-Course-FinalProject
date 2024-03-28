<?php
include_once 'models/Validation.php';

class ValidatorController
{
    /**
     * Se encarga de corroborar que el parametro name
     * cuente con las validaciones necesarias
     */
    public static function validateName(?string $name): array
    {
        if (Validation::isEmpty($name)) {
            return [
                'success' => false,
                'message' => 'Este campo es requerido',
                'param' => 'name',
            ];
        }

        if (!Validation::minAndMaxLeng($name, 5, 25)) {
            return [
                'success' => false,
                'message' => 'La cantidad de caracteres tiene que ser entre 5 y 25',
                'param' => 'name',
            ];
        }

        if (!Validation::validName($name)) {
            return [
                'success' => false,
                'message' => 'No se permiten espacios en blanco ni caracteres especiales',
                'param' => 'name',
            ];
        }

        return ['success' => true];
    }


    /**
     * Se encarga de corroborar que el parametro email
     * cuente con las validaciones necesarias
     */
    public static function validateEmail(?string $email): array
    {
        if (Validation::isEmpty($email)) {
            return [
                'success' => false,
                'message' => 'Este campo es requerido',
                'param' => 'email'
            ];
        }

        if (!Validation::validEmail($email)) {

            return [
                'success' => false,
                'message' => 'No es un email valido',
                'param' => 'email'
            ];
        }

        if (!Validation::minAndMaxLeng($email, 10, 50)) {
            return [
                'success' => false,
                'message' => 'La cantidad de caracteres tiene que ser entre 10 y 50',
                'param' => 'email'
            ];
        }

        return ['success' => true];
    }

    /**
     * Se encarga de corroborar que el parametro password
     * cuente con las validaciones necesarias
     */
    public static function validatePassword(?string $password): array
    {
        if (Validation::isEmpty($password)) {
            return [
                'success' => false,
                'message' => 'Este campo es requerido',
                'param' => 'password'
            ];
        }

        if (!Validation::minAndMaxLeng($password, 5, 50)) {
            return [
                'success' => false,
                'message' => 'La cantidad de caracteres tiene que ser entre 5 y 50',
                'param' => 'password'
            ];
        }

        return ['success' => true];
    }
}
