<?php

namespace App\Http\Controllers\Couleur;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Couleur;
use App\Traits\GeneralTrait;
use Illuminate\Http\Response;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Resources\Couleur\CouleurResource;
use App\Http\Requests\Couleur\StoreCouleurRequest;
use App\Http\Requests\Couleur\UpdateCouleurRequest;


class CouleurController extends Controller
{
    use GeneralTrait;

    /**
     * @OA\Get(
     *      path="/api/couleurs",
     *      operationId="getColors",
     *      tags={"Couleur"},
     *      summary="Retrieve color list",
     *      description="Retrieve the list of all available colors.",
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated",
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request",
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Resource Not Found",
     *     )
     * )
     */
    public function index()
    {
        try {
            $couleurs = Couleur::orderBy('prix', 'asc')->get();
            $couleur = CouleurResource::collection($couleurs);
            return $this->returnData($couleur, 200, 'Liste des couleur réaccordées avec succès');
        } catch (\Exception $exception) {
            return $this->returnError(Response::HTTP_BAD_REQUEST, $exception->getMessage());
        }
    }

    /**
     * @OA\Post(
     *      path="/api/couleurs",
     *      operationId="createColor",
     *      tags={"Couleur"},
     *      summary="Create a new color",
     *      description="Create a new color with the provided data in the request.",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              required={"name", "colorCode"},
     *              @OA\Property(property="name", type="string", example="Red"),
     *              @OA\Property(property="colorCode", type="string", example="#FF0000")
     *          )
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated",
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request",
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Resource Not Found",
     *     )
     * )
     */

    public function store(StoreCouleurRequest $request)
    {
        try {
            $couleur = Couleur::create([
                'name' => $request->name,
                'colorCode' => $request->colorCode,
            ]);
            $couleurQuery = Couleur::orderBy('id', 'desc')->get();
            $couleur = CouleurResource::collection($couleurQuery);
            return $this->returnData($couleur, 200, 'Liste des couleur réaccordé avec Success');
        } catch (\Exception $exception) {
            return $this->returnError(Response::HTTP_BAD_REQUEST, $exception->getMessage());
        }
    }

    /**
     * @OA\Get(
     *      path="/api/couleurs/{id}",
     *      operationId="getColorById",
     *      tags={"Couleur"},
     *      summary="Retrieve color by ID",
     *      description="Retrieve details of a color specified by its ID.",
     *      @OA\Parameter(
     *          name="id",
     *          description="ID of the color to retrieve",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated",
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request",
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Resource Not Found",
     *     )
     * )
     */

    public function show(string $id)
    {
        try {
            $couleur = Couleur::findOrFail($id);
            $couleur = new CouleurResource($couleur);
            return $this->returnData($couleur, 200, 'Couleur réaccordé avec Success');
        } catch (\Exception $exception) {
            return $this->returnError(Response::HTTP_BAD_REQUEST, $exception->getMessage());
        }
    }

    /**
     * @OA\Put(
     *      path="/api/couleurs/{id}",
     *      operationId="updateColor",
     *      tags={"Couleur"},
     *      summary="Update color",
     *      description="Update the specified color with the provided data.",
     *      @OA\Parameter(
     *          name="id",
     *          description="ID of the color to update",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              required={"name", "colorCode"},
     *              @OA\Property(property="name", type="string", example="Blue"),
     *              @OA\Property(property="colorCode", type="string", example="#0000FF")
     *          )
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated",
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request",
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Resource Not Found",
     *     )
     * )
     */

    public function update(UpdateCouleurRequest $request, string $id)
    {
        try {
            $couleur = Couleur::findOrFail($id);

            $dataToUpdate = $request->only(['name', 'colorCode']);
            $couleur->update($dataToUpdate);

            $couleurQuery = Couleur::orderBy('id', 'desc')->get();
            $couleur = CouleurResource::collection($couleurQuery);

            return $this->returnData($couleur, 200, 'Liste des couleur réaccordé avec succès');
        } catch (\Exception $exception) {
            return $this->returnError(Response::HTTP_BAD_REQUEST, $exception->getMessage());
        }
    }

    /**
     * @OA\Delete(
     *      path="/api/couleurs/{id}",
     *      operationId="deleteColor",
     *      tags={"Couleur"},
     *      summary="Delete color",
     *      description="Delete the specified color.",
     *      @OA\Parameter(
     *          name="id",
     *          description="ID of the color to delete",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated",
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request",
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Resource Not Found",
     *     )
     * )
     */

    public function destroy(string $id)
    {
        try {
            $couleur = Couleur::findOrFail($id);
            $couleur->delete();
            $couleurQuery = Couleur::orderBy('id', 'desc')->get();
            $couleur = CouleurResource::collection($couleurQuery);
            return $this->returnData($couleur, 200, 'Liste des livraison réaccordé avec Success');
        } catch (\Exception $exception) {
            return $this->returnError(Response::HTTP_BAD_REQUEST, $exception->getMessage());
        }
    }
}
