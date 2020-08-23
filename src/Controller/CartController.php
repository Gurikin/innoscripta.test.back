<?php

namespace App\Controller;

use App\Entity\Cart;
use App\Entity\CartProduct;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use RuntimeException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class CartController
 * @package App\Controller
 */
class CartController extends AbstractController
{
    private EntityManagerInterface $em;

    /**
     * CartController constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }


    /**
     * @Route("/cart", name="cart", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render('cart/index.html.twig', []);
    }


    /**
     * @Route("/cart/{productId}", name="put_product_to_cart", methods={"PUT"})
     * @param Request $request
     * @param int|null $productId
     * @param ValidatorInterface $validator
     * @return JsonResponse
     */
    public function put(Request $request, ?int $productId, ValidatorInterface $validator): JsonResponse
    {
        if (!$request->hasSession()) {
            return $this->json(['error' => 'You are no customer. Only customers can added products to cart.'], Response::HTTP_BAD_REQUEST);
        }

        try {
            if ($errorMessage = $this->checkInputData($productId, $validator)) {
                return $this->json(['error' => $errorMessage], Response::HTTP_NOT_FOUND);
            }

            if (!($product = $this->getProduct($productId))) {
                return $this->json(['error' => 'Product was not found.'], Response::HTTP_NOT_FOUND);
            }

            $cartProducts = [new CartProduct()];
            $cart = new Cart();

            if ($request->getSession()->has('cartId')) {
                $cartProducts = $this->em->getRepository(CartProduct::class)->findByCartId($request->getSession()->get('cartId'));
                $cart = $this->em->getRepository(Cart::class)->find($request->getSession()->get('cartId'));
            }

            foreach ($cartProducts as $cartProduct) {
                $cartProduct->setCart($cart);
                $cartProduct->setProduct($product);
                $this->em->persist($cartProduct);
            }

            $this->em->flush();
            $request->getSession()->set('cartId', $cart->getId());
        } catch (RuntimeException $e) {
            return $this->json(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->json(['message' => 'ok'], Response::HTTP_OK);
    }

    /**
     * @Route("/cart/{productId}", name="delete_product_from_cart", methods={"DELETE"})
     * @param Request $request
     * @param int $productId
     * @param ValidatorInterface $validator
     * @return JsonResponse
     */
    public function delete(Request $request, int $productId, ValidatorInterface $validator): JsonResponse
    {
        if (!$request->hasSession()) {
            return $this->json(['error' => 'You are no customer. Only customers can added products to cart.'], Response::HTTP_UNAUTHORIZED);
        }

        try {
            if ($errorMessage = $this->checkInputData($productId, $validator)) {
                return $this->json(['error' => $errorMessage], Response::HTTP_NOT_FOUND);
            }

            if (!$request->getSession()->has('cartId')) {
                return $this->json(['error' => 'You have not cart. Something went wrong.'], Response::HTTP_BAD_REQUEST);
            }

            if (!($product = $this->getProduct($productId))) {
                return $this->json(['error' => 'Product was not found.'], Response::HTTP_NOT_FOUND);
            }

            /** @var CartProduct $cartProduct */
            $cartProduct = $this->em->getRepository(CartProduct::class)->findByCartIdProductId($request->getSession()->get('cartId'), $productId);
            $cartProduct->removeProduct($productId);

            $this->em->persist($cartProduct);
            $this->em->flush();
        } catch (RuntimeException $e) {
            return $this->json(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->json(['message' => 'ok'], Response::HTTP_OK);
    }

    private function getProduct(int $productId): ?Product
    {
        return $this->em->getRepository(Product::class)->find($productId);
    }

    /**
     * @param int $productId
     * @param ValidatorInterface $validator
     * @return string
     */
    private function checkInputData(int $productId, ValidatorInterface $validator): ?string
    {
        $errorMessage = null;

        $productIdIsInt = new Assert\Positive();

        $errors = $validator->validate($productId, [$productIdIsInt]);

        if (0 !== count($errors)) {
            $errorMessage = $errors[0]->getMessage();
        }

        return $errorMessage;
    }
}
