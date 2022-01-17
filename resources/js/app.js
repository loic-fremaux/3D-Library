import * as THREE from "three";

import { STLLoader} from "three/examples/jsm/loaders/STLLoader";
import { OrbitControls } from "three/examples/jsm/controls/OrbitControls";

require('./bootstrap');
require('./alpine')

window.tasks = {};

window.clearTasks = async function clearTasks() {
    Object.keys(window.tasks).forEach(key => {
        window.tasks[key] = false;
        console.log('stopping task ' + key)
    });
}

window.create3DBox = function create3DBox(filePath, htmlElementName) {
    let htmlElement = document.getElementById(htmlElementName)

    if (htmlElement === null) {
        console.warn('null html element for ' + htmlElementName)
        return;
    }

    let camera = new THREE.PerspectiveCamera(70, (htmlElement.clientWidth / htmlElement.clientHeight), 1, 1000)

    let renderer = new THREE.WebGLRenderer({
        antialias: true,
        alpha: true
    })

    renderer.setSize(htmlElement.clientWidth, htmlElement.clientHeight)
    htmlElement.appendChild(renderer.domElement)

    window.addEventListener('resize', function () {
        renderer.setSize(htmlElement.clientWidth, htmlElement.clientHeight);
        camera.aspect = (htmlElement.clientWidth / htmlElement.clientHeight);
        camera.updateProjectionMatrix();
    }, false);

    let controls = new OrbitControls(camera, renderer.domElement);
    controls.enableDamping = true;
    controls.rotateSpeed = 0.5;
    controls.dampingFactor = 0.1;
    controls.enableZoom = true;
    controls.autoRotate = true;
    controls.autoRotateSpeed = 1;

    let scene = new THREE.Scene();
    scene.add(new THREE.HemisphereLight(0xffffff, 1.5));

    let taskId = Date.now() + Math.random();

    window.tasks[taskId] = true;

    (new STLLoader()).load(filePath, function (geometry) {
        let material = new THREE.MeshPhongMaterial({
            color: 0x00d1e2,
            specular: 100,
            shininess: 100
        });

        let mesh = new THREE.Mesh(geometry, material);
        scene.add(mesh);

        let middle = new THREE.Vector3();
        geometry.computeBoundingBox();
        geometry.boundingBox.getCenter(middle);
        mesh.geometry.applyMatrix4(new THREE.Matrix4().makeTranslation(
            -middle.x, -middle.y, -middle.z));

        let largestDimension = Math.max(geometry.boundingBox.max.x,
            geometry.boundingBox.max.y,
            geometry.boundingBox.max.z)
        camera.position.z = largestDimension * 2.5; // corresponds to default zoom

        let animate = function () {
            if (!window.tasks[taskId]) {
                console.log('task ' + taskId + ' stopped')
                return;
            }
            requestAnimationFrame(animate);
            controls.update();
            renderer.render(scene, camera);
        };

        animate();
    });

    return taskId;
}
