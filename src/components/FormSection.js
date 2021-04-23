import React, { useState, useEffect } from "react";
import styled from "styled-components";
import QuestionContainer from "./QuestionContainer";
import TeacherSelector from "./TeacherSelector";
import HeaderSection from "./HeaderSection";
import TextAreaFullwidth from "./TextAreaFullwidth";
import { Button, Typography } from "@material-ui/core";
import { useForm } from "react-hook-form";
import axios from "axios";
import getQueryParams from "../utils/getQueryParam";
import Box from "@material-ui/core/Box";

const QuestionSection = styled.section`
  padding: 10px;
`;

export default function FormSection() {
  const [formState, setFormState] = useState([]);
  const [data, setData] = useState([]);
  const [isSubmitting, setisSubmitting] = useState(false);
  const [isFormsubmiited, setIsFormsubmiited] = useState(false);
  const { register, control, handleSubmit } = useForm();
  const { uid, courseid } = getQueryParams();
  // const { uid, courseid } = getQueryParams();
  //   console.log(control);
  const fetchData = async () => {
    const params = { params: { courseid: courseid, uid: uid } };
    const url = process.env.REACT_APP_DOMAIN + "/api/getquestions.php";
    // const url = "/api/getquestions.php";
    const req = await axios.get(url, params);
    //   setAssesmentInfo(req.data.assetmentid);
    setFormState({
      assessment_id: req.data.assetmentid,
      u_id: uid,
      course_id: courseid,
    });
    setData(req.data);

    // console.log(data);
  };
  useEffect(() => {
    fetchData();
  }, []);

  const QuestionIndividual = () => {
    console.log();

    return data.questions.map((data) => {
      return (
        <QuestionContainer
          //   control={Controller}
          assess={control}
          key={data.question}
          question={data.question}
          items={data.items}
          questionId={data.id}
        />
      );
    });
  };

  // const TeacherSelector = () => {
  //   return data.teacher_list.map((teacher, index) => {
  //     return <QuestionContainer key={index} queti />;
  //   });
  // };

  const onSubmitHandle = async (formData) => {
    formState.questions = formData;
    setIsFormsubmiited(true);
    try {
      const url = process.env.REACT_APP_DOMAIN + "/api/createassesment.php";
      const req = await axios.post(url, JSON.stringify(formState));
      const data = await req.data;
      // console.log(data);
      if (data.code === 200) {
        setisSubmitting(true);
      }
    } catch (error) {
      console.log(error);
    }
    // let formData = new FormData(e.target);
    // //   console.log(assesmentInfo)
    // formData.append("questionid", JSON.stringify(assesmentInfo));
    // console.log(formData.getAll("questionid"));
  };

  return (
    <>
      {isSubmitting === false ? (
        data.code !== 208 ? (
          data.length !== 0 ? (
            <>
              <HeaderSection courseshortname={data.course_shortname} />
              <QuestionSection>
                <form onSubmit={handleSubmit(onSubmitHandle)}>
                  <TeacherSelector
                    register={register}
                    teacherLists={data.teacher_list}
                    assess={control}
                  />
                  <QuestionIndividual />
                  <TextAreaFullwidth assess={control} />
                  <Button
                    type="submit"
                    size="large"
                    variant="contained"
                    color="primary"
                    disabled={isFormsubmiited}
                  >
                    ยืนยัน
                  </Button>
                </form>
              </QuestionSection>
            </>
          ) : (
            <Box m={0} mt={20} align="center">
              Loading
            </Box>
          )
        ) : (
          <Box component="div" align="center" m="auto" mt={30}>
            <Typography align="center" variant="h3">
              ดูเหมือนว่า คุณได้ประเมินเรียบร้อยแล้ว
            </Typography>
            <Button
              type="submit"
              size="large"
              variant="contained"
              color="primary"
            >
              กลับหน้าแรก
            </Button>
          </Box>
        )
      ) : (
        <Box component="div" align="center" m={0} mt={30}>
          <Typography align="center" variant="h3">
            ประเมินเรียบร้อยแล้ว
          </Typography>
          <Button
            type="submit"
            size="large"
            variant="contained"
            color="primary"
          >
            กลับหน้าแรก
          </Button>
        </Box>
      )}
    </>
  );
}
